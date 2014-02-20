<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* --------------------------------------------------------------------------------------------------
*
* Controller ACME_Engine_Controller
* 
* Classe abstracao para motor de geração de códigos e instalação do ACME Engine. 
*
* Esta classe contempla os métodos de implementação dos seguintes módulos:
*
*		- App_Installer	(instalador do sistema)
* 		- App_Maker		(criador de módulos internos do sistema)
*
* Para maiores detalhes, analise o conjunto de funções que cada módulo possui através do bloco
* de comentários disponível no decorrer da classe.
*
* @since 	15/10/2012
*
* --------------------------------------------------------------------------------------------------
*/
abstract class ACME_Engine_Controller extends ACME_Core {
	
	public $file_method_process = 'xml';
	public $file_module_extension = 'xml';
	public $path_module_packages = 'application/uploads/acme/packages_update';
	
	/**
	* __construct()
	* Construtor de classe.
	* @return object
	*/
	public function __construct()
	{
		parent::__construct();
	}

	// ------------------------------------------------------------------------------------------
	// CONJUNTO DE FUNÇÕES DO MOTOR DE ACME ENGINE UTILIZADAS NO MÓDULO DE INSTALAÇÃO.
	// ------------------------------------------------------------------------------------------
	// application/controllers/acme/acme_installer => Módulo responsável pela instalação do
	// sistema ACME de forma a torná-lo um novo sistema.
	// O conjunto de funções abaixo contemplam validações dos requisitos do ambiente atual,
	// bibliotecas ativas e conjunto de configurações de banco de dados. São estas funções:
	// 
	// $this->_check_installer_permissions()
	// Verifica as permissões necessárias para o instalador funcionar.
	// 
	// $this->_analyze_system_requirements()
	// Verifica os requisitos de sistema necessários para que o ACME Engine possa ser instalado.
	// 
	// $this->_analyze_install()
	// Analisa os dados do post do formulário de instalação (verifica a integridade, etc).
	// 
	// $this->_install_acme_engine()
	// Realiza a instalação do ACME Engine com base nas informações de post encaminhadas e já
	// validadas anteriormete.
	// ------------------------------------------------------------------------------------------
	
	/**
	* _check_installer_permissions()
	* Checa as permissões necessárias para o installer funcionar. Retorna true caso permissions ok 
	* ou false, caso falta de permissao.
	* @return boolean status
	*/
	public function _check_installer_permissions()
	{
		$return = true;
		if(is_writable('application/controllers') === false && is_readable('application/controllers') === false)
		{
			$return = false;
		} else if(is_writable('application/core') === false && is_readable('application/core') === false) {
			$return = false;
		} else if(is_writable('application/config') === false && is_readable('application/config') === false) {
			$return = false;
		} else if(is_writable('application/config/acme') === false && is_readable('application/config/acme') === false) {
			$return = false;
		} else if(file_exists('application/core/acme/engine_files/installer_dump_database.sql') === false || 
				  file_exists('application/core/acme/engine_files/installer_template_acme_installer.php') === false ||
				  file_exists('application/core/acme/engine_files/installer_template_application_settings.php') === false) {
			$return = false;
		}
		return $return;
	}
	
	/**
	* _analyze_system_requirements()
	* Verifica as configurações do sistema com base no necessário para que o sistema ACME Engine
	* possa ser instalado (configurações de php, banco de dados e extensões). Retorna true em caso
	* de sucesso, ou um array associativo com mensagens de erro. Parametro array com configuracoes
	* de banco de dados deve ser encaminhado.
	* @param array db_params
	* @return mixed status/array
	*/
	public function _analyze_system_requirements($db_params = array())
	{
		// Mensagem de retorno
		$return = array();
		
		// PHP 5.3.5 ou superior
		if(!is_php('5.3.5'))
		{
			$return['php_version'] = lang('PHP 5.3.5 ou superior');
		}
		
		// MySQL 5.0 ou superior
		if(get_value($db_params, 'db_mysql_exists') == '')
		{
			$output = @shell_exec('mysql -V'); 
			@preg_match('@[0-9]+\.[0-9]+\.[0-9]+@', $output, $version); 
			$version = isset($version[0]) ? abs($version[0]) : 0;
			if($version < 5)
			{
				$return['mysql_version'] = lang('MySQL 5.0 ou superior');
			}
		}
		
		// Extensão do mysql no php
		if(!extension_loaded('mysql'))
		{
			$return['php_mysql_extension'] = lang('Extensão <u>mysql</u> ativada no PHP');
		}
		
		// Testa conexão mysql (todos os campos devem estar preenchidos)
		if(get_value($db_params, 'hostname') != '' && get_value($db_params, 'username') != '' && get_value($db_params, 'port') != '' && get_value($db_params, 'database') != '')
		{
			// Abre link de conexão com banco
			$link = @mysqli_connect($db_params['hostname'], $db_params['username'], $db_params['password'], null, $db_params['port']);
			
			// Link com problemas
			if(!$link) {
				$return['mysql_connection'] = mysqli_connect_error();
			} else {
				// Link sem problemas, testa também permissões de usuário
				@mysqli_select_db($link, 'mysql');
				$result = @mysqli_query($link, "SELECT user, select_priv, insert_priv, create_priv FROM mysql.user WHERE host = '" . $db_params['hostname'] . "' AND user = '" . $db_params['username'] . "'");
				$result = @mysqli_fetch_assoc($result);
				
				// Testa privilégios do usuário
				if(strtolower(get_value($result, 'select_priv')) != 'y')
				{
					$return['mysql_user_permission_select'] = lang('Acesso ao banco de dados: usuário sem permissão para realização de consultas - SELECT');
				} elseif(strtolower(get_value($result, 'insert_priv')) != 'y') {
					$return['mysql_user_permission_insert'] = lang('Acesso ao banco de dados: usuário sem permissão para realização de inserções - INSERT');
				} elseif(strtolower(get_value($result, 'create_priv')) != 'y') {
					$return['mysql_user_permission_create'] = lang('Acesso ao banco de dados: usuário sem permissão para criação de tabelas e schemas - CREATE');
				} else {
					// Testa se existe banco de dados com o nome informado
					$result = @mysqli_query($link, "SELECT count(*) AS COUNT_CREATE FROM information_schema.schemata where schema_name = '" . $db_params['database'] . "'");
					$result = @mysqli_fetch_assoc($result);
					
					if(get_value($result, 'COUNT_CREATE') > 0)
					{
						$return['mysql_database_exists'] = lang('Acesso ao banco de dados: schema') . ' <u>' . $db_params['database'] . '</u> ' . lang('já existe');
					}
				}
				
				// Fecha conexão
				@mysqli_close($link);
			}
		} else {
			$return['mysql_connection_information'] = lang('Informações de conexão não encaminhadas');
		}
		
		// Corrige retorno (caso array não tenha sido preenchido 
		// em nenhum lugar, então não ocorreram erros)
		if(count($return) <= 0)
		{
			unset($return);
			$return = true;
		}
		
		// Retorno ajustado
		return $return;
	}
	
	/**
	* analyze_install()
	* Verifica as informações encaminhadas por post de um formulário de instalação do sistema. Retorna
	* true em caso de sucesso ou um array de mensagens de erro.
	* @param array settings (post)
	* @return mixed status/array
	*/
	public function _analyze_install($settings = array())
	{
		$return = array();
		
		// -------------------------------------------------------------
		// VALIDA DIRETÓRIOS (na versão inicial, paths serão engessados)
		// -------------------------------------------------------------
		/*
		if(get_value($settings, 'dir_img') == '')
		{
			$return['dir_img'] = lang('Diretório de imagens não informado');
		} else if(!$this->validation->is_letter_number_chr_specials(get_value($settings, 'dir_js'))) {
			$return['dir_img'] = lang('Diretório de imagens deve conter apenas letras, números, pontos ou underscores');
		}
		if(get_value($settings, 'dir_css') == '')
		{
			$return['dir_css'] = lang('Diretório de estilos (css) não informado');
		} else if(!$this->validation->is_letter_number_chr_specials(get_value($settings, 'dir_js'))) {
			$return['dir_css'] = lang('Diretório de estilos (css) deve conter apenas letras, números, pontos ou underscores');
		}
		if(get_value($settings, 'dir_js') == '')
		{
			$return['dir_js'] = lang('Diretório de scripts não informado');
		} else if(!$this->validation->is_letter_number_chr_specials(get_value($settings, 'dir_js'))) {
			$return['dir_js'] = lang('Diretório de scripts deve conter apenas letras, números, pontos ou underscores');
		}
		*/
		
		
		// ------------------------------------
		// VALIDA INFORMAÇÕES DA NOVA APLICAÇÃO
		// ------------------------------------
		if(get_value($settings, 'info_app_name') == '')
		{
			$return['info_app_name'] = lang('Nome da nova aplicação não informado');
		} else if(!$this->validation->is_letter_number_chr_specials(get_value($settings, 'info_app_name'))) {
			$return['info_app_name'] = lang('Nome da nova aplicação deve conter apenas letras, números, pontos ou underscores');
		}

		if(get_value($settings, 'info_app_title') == '')
		{
			$return['info_app_name'] = lang('Título padrão das páginas da nova aplicação não informado');
		} 
		
		// Valida e upload de logo (se der certo sempre vai substituir o logo atual)
		$config['overwrite'] = true;
		$config['file_name'] = 'logo';
		$config['upload_path'] = PATH_INCLUDE . '/img/';
		$config['allowed_types'] = 'gif|jpg|png|jpeg';
		$config['max_size']	= '2000';
		$config['max_width']  = '180';
		$config['max_height']  = '180';
		$this->load->library('upload', $config);
		if(!$this->upload->do_upload('info_app_logo'))
		{
			$return['info_app_logo'] = $this->upload->display_errors('<span>','</span>');
		}
		
		// DEBUG:
		// $upload_data = $this->upload->data();
		// print_r($upload_data);
		
		if(isset($_FILES['info_app_favicon']['name']))
		{
			if($_FILES['info_app_favicon']['name'] != '')
			{
				unset($config);
				$config['overwrite'] = true;
				$config['file_name'] = '_favicon';
				$config['upload_path'] = PATH_INCLUDE . '/img/';
				$config['allowed_types'] = 'ico';
				$config['max_size']	= '500';
				$config['max_width']  = '16';
				$config['max_height']  = '16';
				$this->upload->initialize($config);
				if(!$this->upload->do_upload('info_app_favicon'))
				{
					$upload_data = $this->upload->data();
					$return['info_app_favicon'] = $this->upload->display_errors('<span>','</span>');
					
					//DEBUG
					// print_r($upload_data);
					// print_r($this->upload);
				}
			}
		} 
		
		
		// ------------------------------------
		// VALIDA INFORMAÇÕES DO USUARIO-MESTRE
		// ------------------------------------
		if(get_value($settings, 'usr_name') == '')
		{
			$return['usr_name'] = lang('Nome do usuário não informado');
		}
		
		if(get_value($settings, 'usr_email') == '')
		{
			$return['usr_email'] = lang('Email do usuário não informado');
		} else if(!$this->validation->is_email(get_value($settings, 'usr_email'))) {
			$return['usr_email'] = lang('Email do usuário deve ser um email válido');
		}
		
		if(get_value($settings, 'usr_login') == '')
		{
			$return['usr_login'] = lang('Login do usuário não informado');
		}
		
		if(get_value($settings, 'usr_pass') == '')
		{
			$return['usr_pass'] = lang('Senha do usuário não informada');
		} else if(get_value($settings, 'usr_pass') != get_value($settings, 'usr_pass_confirm')) {
			$return['usr_pass'] = lang('Senha e confirmar senha não correspondem');
		}
		
		if(get_value($settings, 'usr_pass_confirm') == '')
		{
			$return['usr_pass_confirm'] = lang('Confirmação de senha do usuário não informada');
		}
		
		// Corrige retorno (caso array não tenha sido preenchido 
		// em nenhum lugar, então não ocorreram erros)
		if(count($return) <= 0)
		{
			unset($return);
			$return = true;
		}
		// Retorno ajustado
		return $return;
	}
	
	/**
	* install_acme_engine()
	* Instala o subsistema ACME Engine. Espera que anteriormente a chamada desta função seja
	* analisado as configurações, através do método _analyze_install.
	* @param array settings (post)
	* @return void
	*/
	public function _install_acme_engine($settings = array())
	{
		// Carrega helper de segurança
		$this->load->helper('security');
		
		// -----------------------------------
		// CRIAÇÃO DE BANCO DE DADOS INFORMADO
		// -----------------------------------
		// Conecta no banco utilizando objeto do CI
		$config['hostname'] = get_value($settings, 'db_host');
		$config['username'] = get_value($settings, 'db_user');
		$config['password'] = get_value($settings, 'db_pass');
		$config['database'] = '';
		$config['dbdriver'] = "mysql";
		$config['dbprefix'] = "";
		$config['pconnect'] = FALSE;
		$config['db_debug'] = TRUE;
		$config['cache_on'] = FALSE;
		$config['cachedir'] = "";
		$config['char_set'] = "utf8";
		$config['dbcollat'] = "utf8_general_ci";
		$this->load->database($config);
		$this->load->dbforge();
		
		// Se conseguir criar banco, prossegue com importação
		if($this->dbforge->create_database(get_value($settings, 'db_database')))
		{
			// Recria obj db com database informado
			unset($this->db);
			$config['database'] = get_value($settings, 'db_database');
			$this->load->database($config);
			
			// Carrega script de dump do banco de dados
			$link = mysqli_connect(get_value($settings, 'db_host'), get_value($settings, 'db_user'), get_value($settings, 'db_pass'), get_value($settings, 'db_database'), get_value($settings, 'db_port'));
			$result = mysqli_multi_query($link, str_replace('<DATABASE>', get_value($settings, 'db_database'), file_get_contents('application/core/acme/engine_files/installer_dump_database.sql')));
			
			// Varre todas as instruções armazenadas para acabar com o asincrono
			do {
				if($result = mysqli_store_result($link)){
					mysqli_free_result($result);
				}
			} while(mysqli_next_result($link));

			// Caso não existam erros no dump
			if(!mysqli_error($link)) {
				
				// Fecha conexão e prossegue com objeto do CI
				mysqli_close($link);
				
				// Faz update do usuário-mestre pelo informado
				$this->db->set('login', xss_clean(get_value($settings, 'usr_login')), true);
				$this->db->set('password', md5(get_value($settings, 'usr_pass')), true);
				$this->db->set('name', str_replace("'", "''", get_value($settings, 'usr_name')), true);
				$this->db->set('email', str_replace("'", "''", get_value($settings, 'usr_email')), true);
				$this->db->set('log_dtt_ins', 'CURRENT_TIMESTAMP', false);
				$this->db->where(array('id_user' => 1));
				$this->db->update('acm_user');
			}
		}
		
		// Substitui conteúdo do arquivo settings (do acme)
		$settings_file = file_get_contents('application/core/acme/engine_files/installer_template_application_settings.php');
		$settings_file = str_replace('<APP_NAME>', get_value($settings, 'info_app_name'), $settings_file);
		$settings_file = str_replace('<APP_TITLE>', get_value($settings, 'info_app_title'), $settings_file);
		$settings_file = str_replace('<DB_HOST>', get_value($settings, 'db_host'), $settings_file);
		$settings_file = str_replace('<DB_PORT>', get_value($settings, 'db_port'), $settings_file);
		$settings_file = str_replace('<DB_USER>', get_value($settings, 'db_user'), $settings_file);
		$settings_file = str_replace('<DB_PASS>', get_value($settings, 'db_pass'), $settings_file);
		$settings_file = str_replace('<DB_DATABASE>', get_value($settings, 'db_database'), $settings_file);
		$settings_file = str_replace('<EMAIL_PROTOCOL>', get_value($settings, 'email_protocol'), $settings_file);
		$settings_file = str_replace('<EMAIL_SMTP_HOST>', get_value($settings, 'email_smtp_host'), $settings_file);
		$settings_file = str_replace('<EMAIL_SMTP_PORT>', get_value($settings, 'email_smtp_port'), $settings_file);
		$settings_file = str_replace('<EMAIL_SMTP_TIMEOUT>', get_value($settings, 'email_smtp_timeout'), $settings_file);
		$settings_file = str_replace('<EMAIL_SMTP_USER>', get_value($settings, 'email_smtp_user'), $settings_file);
		$settings_file = str_replace('<EMAIL_SMTP_PASS>', get_value($settings, 'email_smtp_pass'), $settings_file);
		$settings_file = str_replace('<EMAIL_GLOBAL_NAME_FROM>', get_value($settings, 'email_global_name_from'), $settings_file);
		$settings_file = str_replace('<EMAIL_GLOBAL_ADDRESS_FROM>', get_value($settings, 'email_global_address_from'), $settings_file);
		file_put_contents('application/config/application_settings.php', $settings_file);
		
		// Substitui conteudo do arquivo routes (para direcionar para a tela de login)
		$routes_file = file_get_contents('application/config/routes.php');
		file_put_contents('application/config/routes.php', str_replace('$route[\'default_controller\'] = "acme/acme_installer";', '$route[\'default_controller\'] = "acme/acme_access";', $routes_file));
		
		// Substitui o core, faz carregar database
		$core_file = file_get_contents('application/core/acme/acme_core.php');
		file_put_contents('application/core/acme/acme_core.php', str_replace('// <LOAD_DATABASE>', '$this->load->database();', $core_file));
		
		// Substitui o app_config, faz carregar variáveis do banco de dados
		$core_file = file_get_contents('application/libraries/acme/app_config.php');
		file_put_contents('application/libraries/acme/app_config.php', str_replace('// <LOAD_CONFIGS_DATABASE>', '$this->load_configs_db();', $core_file));
		
		// Substitui conteúdo do acme_access
		$access_file = file_get_contents('application/controllers/acme/acme_access.php');
		file_put_contents('application/controllers/acme/acme_access.php', str_replace('redirect(\'acme_installer\');', '', $access_file));
		
		// Substitui arquivo installer
		$installer_file = file_get_contents('application/core/acme/engine_files/installer_template_acme_installer.php');
		file_put_contents('application/controllers/acme/acme_installer.php', $installer_file);
	}
	
	
	
	// ------------------------------------------------------------------------------------------
	// CONJUNTO DE FUNÇÕES DO MÓDULO MAKER, OU CRIADOR DE MÓDULOS INTERNOS DO SISTEMA
	// ------------------------------------------------------------------------------------------
	// application/controllers/acme/acme_maker => Módulo responsável pela criação de outros
	// módulos internos do sistema. O conjunto de funções abaixo contemplam validações dos requisitos 
	// necessários para a construção de um novo módulo, validações de arquivos de módulos, paths
	// e afins.
	// 
	// $this->_check_maker_permissions()
	// Verifica as permissões necessárias para o maker funcionar.
	// 
	// $this->_check_path_permissions()
	// Verifica as permissões de um determinado path.
	// 
	// $this->_create_module_file()
	// Cria um arquivo de módulo com base numa string xml/ini de arquivo encaminhada.
	// 
	// $this->_update_module_file()
	// Atualiza o conteúdo de um arquivo de módulo já criado anteriormente.
	//
	// $this->_delete_module_file()
	// Remove um arquivo de módulo anteriormente criado.
	//
	// $this->_analyze_module_file()
	// Analisa a integridade e conteúdo de um arquivo de módulo criado com base no método de
	// criação setado para leitura e validação atualmente nesta classe.
	//
	// $this->_analyze_module_file_ini()
	// Analisa a integridade e conteúdo de um arquivo de módulo utilizando metodo de leitura de
	// arquivos no formato .ini
	// 
	// $this->_analyze_module_file_xml()
	// Analisa a integridade e conteúdo de um arquivo de módulo utilizando metodo de leitura de
	// arquivos no formato .xml
	// 
	// $this->_analyze_table()
	// Analisa a integridade e formato de uma tabela informada no conteúdo do arquivo de módulo, 
	// verificando se ela está no formato adequado.
	// 
	// $this->_process_module_file()
	// Processa um arquivo de módulo, anteriormente validado, com base no método de leitura/criação
	// atualmente setado para esta classe.
	// 
	// $this->_process_module_file_ini()
	// Processa um arquivo de módulo no formato ini, retorna um array com os dados formatados 
	// do módulo.
	// 
	// $this->_process_module_file_xml()
	// Processa um arquivo de módulo no formato xml, retorna um array com os dados formatados 
	// do módulo.
	// 
	// $this->_create_module()
	// Cria um módulo, com base no arquivo de módulo de nome encaminhado.
	// 
	// $this->_get_skeleton_module_file()
	// Retorna o conteúdo do esqueleto de um arquivo de módulo, com base no tipo encaminhado 
	// (ini ou xml).
	// 
	// $this->_get_skeleton_custom_section()
	// Para arquivos tipo ini, retorna o conteúdo de uma seção específica de string encaminhada.
	//
	// $this->_get_skeleton_custom_section()
	// Para arquivos tipo ini, retorna o conteúdo de uma seção específica de string encaminhada.
	// ------------------------------------------------------------------------------------------
	/**
	* _check_maker_permissions()
	* Checa as permissões necessárias para o maker funcionar. Retorna true caso permissions ok 
	* ou false, caso falta de permissao.
	* @return boolean status
	*/
	public function _check_maker_permissions()
	{
		$return = true;
		if(is_writable('application/controllers') === false && @opendir('application/controllers') === false)
		{
			$return = false;
		} else if(is_writable('application/models') === false && @opendir('application/models') === false) {
			$return = false;
		} else if(is_writable('application/views/' . TEMPLATE) === false && @opendir('application/views/' . TEMPLATE) === false) {
			$return = false;
		} else if(is_writable('application/core/acme/engine_files') === false && @opendir('application/core/acme/engine_files') === false) {
			$return = false;
		} else if(file_exists('application/core/acme/engine_files/maker_template_controller.php') === false || 
				  file_exists('application/core/acme/engine_files/maker_template_model.php') === false || 
				  file_exists('application/core/acme/engine_files/maker_template_module_file.xml') === false ||
				  file_exists('application/core/acme/engine_files/maker_template_module_file.ini') === false ||
				  file_exists('application/core/acme/engine_files/maker_template_module_file_custom_action.ini') === false ||
				  file_exists('application/core/acme/engine_files/maker_template_module_file_custom_menu.ini') === false ||
				  file_exists('application/core/acme/engine_files/maker_template_module_file_custom_permission.ini') === false) {
			$return = false;
		}
		return $return;
	}
	
	/**
	* _check_path_permissions()
	* Checa as permissões de um path de nome encaminhado. Retorna true caso path possa ser escrito 
	* e lido ou false, caso falta de permissao.
	* @param string path_name
	* @return boolean status
	*/
	public function _check_path_permissions($path_name = '')
	{
		return (is_writable($path_name) === false && @opendir($path_name) === false) ? false : true;
	}
	
	/**
	* _check_file_permissions()
	* Checa as permissões de um arquivo de módulo de nome encaminhado. Retorna true caso
	* arquivo possa ser escrito e lido ou false, caso falta de permissao.
	* @param string file_name
	* @return boolean status
	*/
	public function _check_file_permissions($file_name = '')
	{
		return (is_writable($file_name) === false && is_readable($file_name) === false) ? false : true;
	}
	
	/**
	* _create_module_file()
	* Cria arquivo de módulo com base em uma string encaminhada. Retorna nome do arquivo
	* em caso de sucesso ou false, caso falha na criação. A criação de arquivo se baseia na extensão 
	* atualmente setada para módulos (default: xml).
	* @param string file_content
	* @param string path_module_files
	* @return mixed (file_name/status)
	*/
	public function _create_module_file($ini_string = '', $path_module_files = '')
	{
		// Parse básico no conteúdo
		$content = @parse_ini_string($ini_string, true);
		
		// Coleta seção module, do conteudo
		$module = get_value($content, 'module');
		
		// Nome do arquivo
		$file_name = (get_value($module, 'controller') != '') ? get_value($module, 'controller') . '_' . uniqid() : uniqid();
		$path_file_name = $path_module_files . '/' . $file_name . '.' . $this->file_module_extension;
		
		if(file_put_contents($path_file_name, $ini_string) === false)
		{
			return false;
		} else {
			return $file_name . '.' . $this->file_module_extension;
		}
	}
	
	/**
	* _update_module_file()
	* Altera o conteudo de um arquivo de módulo (.ini) com base em uma string_ini encaminhada. 
	* Retorna true ou false, caso falhe a operação.
	* @param string ini_string
	* @param string file_name
	* @return boolean status
	*/
	public function _update_module_file($ini_string = '', $file_name = '')
	{
		return (file_put_contents($file_name, $ini_string) === false) ? false : true;
	}
	
	/**
	* _delete_module_file()
	* Deleta um arquivo de de módulo (.ini) com base em no nome de arquivo encaminhado. 
	* Retorna true ou false, caso falhe a operação.
	* @param string file_name
	* @return boolean status
	*/
	public function _delete_module_file($file_name = '')
	{
		return unlink($file_name);
	}
	
	/**
	* _analyze_module_file()
	* Analisa o arquivo de nome encaminhado, verificando se ele preenche as regras básicas de
	* um arquivo de configuração de módulo, isto é, se possui as seções obrigatórias e se os valores
	* das chaves estão dentro do esperado. Retorna true caso arquivo válido, outro caso, um array
	* associativo de mensagens de erro, contendo a seção que deu problema e a chave desta seção. A 
	* análise é feita com base no método de processamento atualmente setado (default: xml).
	* @param string file_name
	* @return mixed status/array
	*/
	public function _analyze_module_file($file_name = '')
	{
		switch(strtolower($this->file_method_process))
		{
			case 'ini':
				return $this->_analyze_module_file_ini($file_name);
			break;
			
			case 'xml':
			default:
				return $this->_analyze_module_file_xml($file_name); 
			break;
		}
	}
	
	/**
	* _analyze_module_file_ini()
	* Analisa o arquivo de nome encaminhado tendo como base o método de validação de arquivos de
	* extensão .ini (configuração). Verifica seções obrigatórias e retorna array contendo erros
	* ou true, caso arquivo seja válido.
	* @param string file_name
	* @return mixed status/array
	*/
	public function _analyze_module_file_ini($file_name = '')
	{
		// Inicializa Variável de erro/retorno
		$return = array();
		
		if(@parse_ini_file($file_name, true) == true)
		{
			// Abre o arquivo, le e parse no conteudo
			$file = file_get_contents($file_name);
			$content = parse_ini_string($file, true);
			
			// DEBUG:
			// print_r($content);
			
			// 1 verificação: chaves principais existem
			$main_keys = array_flip(array('module', 'forms', 'permissions', 'actions', 'menus', 'link_to_module'));
			foreach($main_keys as $key => $value)
			{
				if(array_key_exists($key, $content) === false)
				{
					$return[$key]['error'] = lang('A seção <strong>[' . $key . ']</strong> não foi definida no arquivo encaminhado.');
				} 
				
				// Chave existe, valida valores internos
				else {
					// Retira a porção seção do array parseado
					$section = $content[$key];
					switch($key)
					{
						// -----------------------
						// VALIDA A SEÇÃO [module]
						// -----------------------
						case 'module':						
							// Verifica se tabela existe no banco de dados
							if(array_key_exists('table', $section))
							{
								if(get_value($section, 'table') != '')
								{
									if(!$this->db->table_exists(get_value($section, 'table')))
									{
										$return[$key]['table']['error'] = lang('<strong>[module] table: </strong>A tabela ') . get_value($section, 'table') . lang(' parece não existir no banco de dados.');
									} else if(!$this->_analyze_table(get_value($section, 'table'))) {
										$return[$key]['table']['error'] = lang('<strong>[module] table: </strong>A tabela ') . get_value($section, 'table') . lang(' parece não possuir uma única chave primária (PK) com <strong>AUTO INCREMENT</strong>.');
									}
								}
							}
							
							// Verifica existencia e nome do controlador
							if(array_key_exists('controller', $section))
							{
								if(get_value($section, 'controller') == '')
								{
									$return[$key]['controller']['error'] = lang('<strong>[module] controller: </strong>Não pode ser vazio.');
								} else if($this->validation->is_class_name(get_value($section, 'controller')) == false)
								{
									$return[$key]['controller']['error'] = lang('<strong>[module] controller: </strong>O valor informado para o nome do controlador deve ser um nome de classe válido (nome informado: ') . get_value($section, 'controller') . ').';
								} else if(class_exists(get_value($section, 'controller'))) {
									$return[$key]['controller']['error'] = lang('<strong>[module] controller: </strong>Uma classe já existe com o nome do controlador informado (nome: ') . get_value($section, 'controller') . ').';
								}
							} else {
								$return[$key]['controller']['error'] = lang('<strong>[module] controller: </strong>Propriedade controller (seção module) não informada no arquivo.');
							}
							
							// Verifica a existencia e valor setado para rótulo
							if(array_key_exists('rotule', $section))
							{
								if(get_value($section, 'rotule') == '')
								{
									$return[$key]['rotule']['error'] = lang('<strong>[module] rotule: </strong>Não pode ser vazio.');
								}
							} else {
								$return[$key]['rotule']['error'] = lang('<strong>[module] rotule: </strong>Propriedade rotule (seção module) não informada no arquivo.');
							}
							
							// Valida numero de itens por pagina (opcional, é validado apenas caso preenchido)
							if(array_key_exists('items_per_page', $section))
							{
								if(get_value($section, 'items_per_page') != '' && $this->validation->is_integer_(get_value($section, 'items_per_page')) == false)
								{
									$return[$key]['items_per_page']['error'] = lang('<strong>[module] items_per_page: </strong>Deve ser um número inteiro.');
								}
							}
							
							// Valida numero de itens por pagina (opcional, é validado apenas caso preenchido)
							if(array_key_exists('order', $section))
							{
								if(get_value($section, 'order') != '' && $this->validation->is_integer_(get_value($section, 'order')) == false)
								{
									$return[$key]['order']['error'] = lang('<strong>[module] order: </strong>Deve ser um número inteiro.');
								}
							} else {
								$return[$key]['order']['error'] = lang('<strong>[module] order: </strong>Propriedade order (seção module) não informada no arquivo.');
							}
						break;
						
						// -------------------------------
						// VALIDA A SEÇÃO [link_to_module]
						// -------------------------------
						case 'link_to_module':						
							// Usar menu de acesso
							if(array_key_exists('use_menu', $section))
							{
								if(strtolower(get_value($section, 'use_menu')) != 'y' && strtolower(get_value($section, 'use_menu')) != 's' && strtolower(get_value($section, 'use_menu')) != 'n')
								{
									$return[$key]['use_menu']['error'] = lang('<strong>[link_to_module] use_menu: </strong>Deve conter um valor válido (y, s ou n).');
								}
							} else {
								$return[$key]['use_menu']['error'] = lang('<strong>[link_to_module] use_menu: </strong>Propriedade use_menu (seção link_to_module) não informada no arquivo.');
							}
							
							// Usar menu de acesso
							if(array_key_exists('apply_groups', $section))
							{
								if(strtolower(get_value($section, 'apply_groups')) != '')
								{
									// Divide a lista de grupos
									$groups = trim(trim(get_value($section, 'apply_groups')), ',');
									$arr_groups = array();
									$arr_groups = explode(',', $groups);
									
									// Variavel de teste de grupos que falharam
									$groups_fail = '';
									
									// Verifica a existencia dos grupos informados
									if(count($arr_groups) > 0)
									{
										foreach($arr_groups as $group)
										{
											$query = $this->db->get_where('acm_user_group', array('name' => trim($group)));
											$groups_fail .= ($query->num_rows() <= 0) ? $group . ', ' : '';
										}
									}
									
									if($groups_fail != '')
									{
										// Escapa grupos
										$groups_fail = trim(trim($groups_fail), ',');
										$return[$key]['apply_groups']['error'] = lang('<strong>[link_to_module] apply_groups: </strong>Grupos não encontrados no banco de dados') . ' (' . $groups_fail . ').';
									}
								}
							} else {
								$return[$key]['use_menu']['error'] = lang('<strong>[link_to_module] use_menu: </strong>Propriedade use_menu (seção link_to_module) não informada no arquivo.');
							}
						break;
						
						// ----------------------
						// VALIDA A SEÇÃO [forms]
						// ----------------------
						case 'forms':
							// Formulario de insercao
							if(array_key_exists('insert', $section))
							{
								if(strtolower(get_value($section, 'insert')) != 'y' && strtolower(get_value($section, 'insert')) != 's' && strtolower(get_value($section, 'insert')) != 'n')
								{
									$return[$key]['insert']['error'] = lang('<strong>[forms] insert: </strong>Deve conter um valor válido (y, s ou n).');
								}
							} else {
								$return[$key]['insert']['error'] = lang('<strong>[forms] insert: </strong>Propriedade insert (seção forms) não informada no arquivo.');
							}
							
							// Formulario de edicao
							if(array_key_exists('update', $section))
							{
								if(strtolower(get_value($section, 'update')) != 'y' && strtolower(get_value($section, 'update')) != 's' && strtolower(get_value($section, 'update')) != 'n')
								{
									$return[$key]['update']['error'] = lang('<strong>[forms] update: </strong>Deve conter um valor válido (y, s ou n).');
								}
							} else {
								$return[$key]['update']['error'] = lang('<strong>[forms] update: </strong>Propriedade update (seção forms) não informada no arquivo.');
							}
							
							// Formulario de delecao
							if(array_key_exists('delete', $section))
							{
								if(strtolower(get_value($section, 'delete')) != 'y' && strtolower(get_value($section, 'delete')) != 's' && strtolower(get_value($section, 'delete')) != 'n')
								{
									$return[$key]['delete']['error'] = lang('<strong>[forms] delete: </strong>Deve conter um valor válido (y, s ou n).');
								}
							} else {
								$return[$key]['delete']['error'] = lang('<strong>[forms] delete: </strong>Propriedade delete (seção forms) não informada no arquivo.');
							}
							
							// Formulario de visualizacao
							if(array_key_exists('view', $section))
							{
								if(strtolower(get_value($section, 'view')) != 'y' && strtolower(get_value($section, 'view')) != 's' && strtolower(get_value($section, 'view')) != 'n')
								{
									$return[$key]['view']['error'] = lang('<strong>[forms] view: </strong>Deve conter um valor válido (y, s ou n).');
								}
							} else {
								$return[$key]['view']['error'] = lang('<strong>[forms] view: </strong>Propriedade view (seção forms) não informada no arquivo.');
							}
						break;
						
						
						// ----------------------------
						// VALIDA A SEÇÃO [permissions]
						// ----------------------------
						case 'permissions':
							// Permissao de insercao
							if(array_key_exists('insert', $section))
							{
								if(strtolower(get_value($section, 'insert')) != 'y' && strtolower(get_value($section, 'insert')) != 's' && strtolower(get_value($section, 'insert')) != 'n')
								{
									$return[$key]['insert']['error'] = lang('<strong>[permissions] insert: </strong>Deve conter um valor válido (y, s ou n).');
								}
							} else {
								$return[$key]['insert']['error'] = lang('<strong>[permissions] insert: </strong>Propriedade insert (seção permissions) não informada no arquivo.');
							}
							
							// Permissao de edicao
							if(array_key_exists('update', $section))
							{
								if(strtolower(get_value($section, 'update')) != 'y' && strtolower(get_value($section, 'update')) != 's' && strtolower(get_value($section, 'update')) != 'n')
								{
									$return[$key]['update']['error'] = lang('<strong>[permissions] update: </strong>Deve conter um valor válido (y, s ou n).');
								}
							} else {
								$return[$key]['update']['error'] = lang('<strong>[permissions] update: </strong>Propriedade update (seção permissions) não informada no arquivo.');
							}
							
							// Permissao de delecao
							if(array_key_exists('delete', $section))
							{
								if(strtolower(get_value($section, 'delete')) != 'y' && strtolower(get_value($section, 'delete')) != 's' && strtolower(get_value($section, 'delete')) != 'n')
								{
									$return[$key]['delete']['error'] = lang('<strong>[permissions] delete: </strong>Deve conter um valor válido (y, s ou n).');
								}
							} else {
								$return[$key]['delete']['error'] = lang('<strong>[permissions] delete: </strong>Propriedade delete (seção permissions) não informada no arquivo.');
							}
							
							// Permissao de visualizacao
							if(array_key_exists('view', $section))
							{
								if(strtolower(get_value($section, 'view')) != 'y' && strtolower(get_value($section, 'view')) != 's' && strtolower(get_value($section, 'view')) != 'n')
								{
									$return[$key]['view']['error'] = lang('<strong>[permissions] view: </strong>Deve conter um valor válido (y, s ou n).');
								}
							} else {
								$return[$key]['view']['error'] = lang('<strong>[permissions] view: </strong>Propriedade view (seção permissions) não informada no arquivo.');
							}
							
							// Permissao de entrada do modulo
							if(array_key_exists('enter', $section))
							{
								if(strtolower(get_value($section, 'enter')) != 'y' && strtolower(get_value($section, 'enter')) != 's' && strtolower(get_value($section, 'enter')) != 'n')
								{
									$return[$key]['enter']['error'] = lang('<strong>[permissions] enter: </strong>Deve conter um valor válido (y, s ou n).');
								}
							} else {
								$return[$key]['enter']['error'] = lang('<strong>[permissions] enter: </strong>Propriedade enter (seção permissions) não informada no arquivo.');
							}
						break;
						
						
						// ---------------------------------------------------
						// VALIDA A SEÇÃO [actions] (são opcionais os valores)
						// ---------------------------------------------------
						case 'actions':
							// Ação de edição
							if(array_key_exists('update', $section))
							{
								if(strtolower(get_value($section, 'update')) != 'y' && strtolower(get_value($section, 'update')) != 's' && strtolower(get_value($section, 'update')) != 'n')
								{
									$return[$key]['update']['error'] = lang('<strong>[actions] update: </strong>Deve conter um valor válido (y, s ou n).');
								}
							} else {
								$return[$key]['update']['error'] = lang('<strong>[actions] update: </strong>Propriedade update (seção actions) não informada no arquivo.');
							}
							
							// Ação de deleção
							if(array_key_exists('delete', $section))
							{
								if(strtolower(get_value($section, 'delete')) != 'y' && strtolower(get_value($section, 'delete')) != 's' && strtolower(get_value($section, 'delete')) != 'n')
								{
									$return[$key]['delete']['error'] = lang('<strong>[actions] delete: </strong>Deve conter um valor válido (y, s ou n).');
								}
							} else {
								$return[$key]['delete']['error'] = lang('<strong>[actions] delete: </strong>Propriedade delete (seção actions) não informada no arquivo.');
							}
							
							// Ação de visualização
							if(array_key_exists('view', $section))
							{
								if(strtolower(get_value($section, 'view')) != 'y' && strtolower(get_value($section, 'view')) != 's' && strtolower(get_value($section, 'view')) != 'n')
								{
									$return[$key]['view']['error'] = lang('<strong>[actions] view: </strong>Deve conter um valor válido (y, s ou n).');
								}
							} else {
								$return[$key]['view']['error'] = lang('<strong>[actions] view: </strong>Propriedade view (seção actions) não informada no arquivo.');
							}
						break;
						
						// -------------------------------------------------
						// VALIDA A SEÇÃO [menus] (são opcionais os valores)
						// -------------------------------------------------
						case 'menus':
							// Ação de edição
							if(array_key_exists('insert', $section))
							{
								if(strtolower(get_value($section, 'insert')) != 'y' && strtolower(get_value($section, 'insert')) != 's' && strtolower(get_value($section, 'insert')) != 'n')
								{
									$return[$key]['insert']['error'] = lang('<strong>[menus] insert: </strong>Deve conter um valor válido (y, s ou n).');
								}
							} else {
								$return[$key]['insert']['error'] = lang('<strong>[menus] insert: </strong>Propriedade insert (seção menus) não informada no arquivo.');
							}
						break;
						
						default:
						break;
					}
				}
			}
			
			// Prossegue com validações (AGORA PARA SEÇÕES CUSTOM)
			if(count($content) > 0)
			{
				// echo 'pararat';
				// Procura por seções 
				foreach($content as $key => $value)
				{
					// Cata todas as ocorrencias de menus customizados
					if(preg_match_all('/^custom_menu[\s]*[:][\w\d\s]*/i', $key, $matches))
					{
						foreach($matches[0] as $pos => $key_menu)
						{
							$menu = get_value($content, $key_menu);
							
							// Valida rótulo
							if(array_key_exists('rotule', $menu))
							{
								if(get_value($menu, 'rotule') == '')
								{
									$return[$key_menu]['rotule']['error'] = '<strong>[' . $key_menu . '] rotule: </strong>' . lang('Não pode ser vazio.');
								}
							} else {
								$return[$key_menu]['rotule']['error'] = '<strong>[' . $key_menu . '] rotule: </strong>' . lang('Propriedade rotule (seção de menu customizado) não informada no arquivo.');
							}
							
							// Valida link
							if(array_key_exists('link', $menu))
							{
								if(get_value($menu, 'link') == '')
								{
									$return[$key_menu]['link']['error'] = '<strong>[' . $key_menu . '] link: </strong>' . lang('Não pode ser vazio.');
								}
							} else {
								$return[$key_menu]['link']['error'] = '<strong>[' . $key_menu . '] link: </strong>' . lang('Propriedade link (seção de menu customizado) não informada no arquivo.');
							}
						}
					}
					
					// Cata todas as ocorrencias de action customizados
					if(preg_match_all('/^custom_action[\s]*[:][\w\d\s]*/i', $key, $matches))
					{
						foreach($matches[0] as $pos => $key_action)
						{
							$action = get_value($content, $key_action);
							
							// Valida rótulo
							if(array_key_exists('rotule', $action))
							{
								if(get_value($action, 'rotule') == '')
								{
									$return[$key_action]['rotule']['error'] = '<strong>[' . $key_action . '] rotule: </strong>' . lang('Não pode ser vazio.');
								}
							} else {
								$return[$key_action]['rotule']['error'] = '<strong>[' . $key_action . '] rotule: </strong>' . lang('Propriedade rotule (seção de action customizado) não informada no arquivo.');
							}
							
							// Valida link
							if(array_key_exists('link', $action))
							{
								if(get_value($action, 'link') == '')
								{
									$return[$key_action]['link']['error'] = '<strong>[' . $key_action . '] link: </strong>' . lang('Não pode ser vazio.');
								}
							} else {
								$return[$key_action]['link']['error'] = '<strong>[' . $key_action . '] link: </strong>' . lang('Propriedade link (seção de action customizado) não informada no arquivo.');
							}
						}
					}
					
					// Cata todas as ocorrencias de permissions customizados
					if(preg_match_all('/^custom_permission[\s]*[:][\w\d\s]*/i', $key, $matches))
					{
						foreach($matches[0] as $pos => $key_permission)
						{
							$permission = get_value($content, $key_permission);
							
							// Valida rótulo
							if(array_key_exists('rotule', $permission))
							{
								if(get_value($permission, 'rotule') == '')
								{
									$return[$key_permission]['rotule']['error'] = '<strong>' . $key_permission . ': </strong>' . lang('Não pode ser vazio.');
								}
							} else {
								$return[$key_permission]['rotule']['error'] = '<strong>' . $key_permission . ': </strong>' . lang('Propriedade rotule (seção de permission customizado) não informada no arquivo.');
							}
							
							// Valida nome da permissao
							if(array_key_exists('permission_name', $permission))
							{
								if(get_value($permission, 'permission_name') == '')
								{
									$return[$key_permission]['permission_name']['error'] = '<strong>[' . $key_permission . '] permission_name: </strong>' . lang('Não pode ser vazio.');
								} else if(preg_match('/^[a-zA-Z0-9_.]+$/', get_value($permission, 'permission_name')) == false) {
									$return[$key_permission]['permission_name']['error'] = '<strong>[' . $key_permission . '] permission_name: </strong>' . lang('Deve conter apenas letras, números e underscore \'_\'.');
								}
							} else {
								$return[$key_permission]['permission_name']['error'] = '<strong>[' . $key_permission . '] permission_name: </strong>' . lang('Propriedade permission_name (seção de permission customizado) não informada no arquivo.');
							}
						}
					}
				}
			}
		} else {
			$this->error->show_exception_page(lang('Arquivo') . ' <strong>' . $file_name . '</strong> ' . lang('contém erros em seu formato. Verifique o conteúdo do arquivo e tente novamente. Caso persistam os problemas, leia sobre a formatação de arquivos <strong>.ini</strong>.'));
		}
		
		// Corrige retorno (caso array não tenha sido preenchido 
		// em nenhum lugar, então não ocorreram erros)
		if(count($return) <= 0)
		{
			unset($return);
			$return = true;
		}
		
		// Retorno ajustado
		return $return;
	}
	
	/**
	* _analyze_module_file_xml()
	* Analisa o arquivo de nome encaminhado tendo como base o método de validação de arquivos de
	* extensão .xml. Verifica tags obrigatórias e seu conteudo, retornando array contendo erros
	* ou true, caso arquivo seja válido.
	* @param string file_name
	* @return mixed status/array
	*/
	public function _analyze_module_file_xml($file_name = '')
	{
		// Inicializa Variável de erro/retorno
		$return = array();
		
		try { 
			// Seta mapeamento de erros internos e em seguida Analisa o 
			// arquivo (verifica tags obrigatórias e seu conteudo)
			libxml_use_internal_errors(true);
			$xml = @new SimpleXMLElement(file_get_contents($file_name));
			
			// TABLE
			if($xml->table != '')
			{
				if(!$this->db->table_exists($xml->table))
				{
					$return['table'] = lang('<strong>Dados do módulo:</strong> a tabela informada no nodo <strong>&lt;table&gt;&lt;/table&gt;</strong> não existe no banco de dados') . ' (' . $xml->table . ').';
				} else if(!$this->_analyze_table($xml->table)) {
					$return['table'] = lang('<strong>Dados do módulo:</strong> a tabela informada no nodo <strong>&lt;table&gt;&lt;/table&gt;</strong> não possui uma única chave primária (PK) com <strong>AUTO INCREMENT</strong>')  . ' (' . $xml->table . ').';
				}
			}
			
			// CONTROLLER
			if($xml->controller == '')
			{
				$return['controller'] = lang('<strong>Dados do módulo:</strong> nodo <strong>&lt;controller&gt;&lt;/controller&gt;</strong> não está presente ou seu conteúdo está vazio.');
			} else if($this->validation->is_class_name($xml->controller) == false) {
				$return['controller'] = lang('<strong>Dados do módulo:</strong> nodo <strong>&lt;controller&gt;&lt;/controller&gt;</strong> deve conter um nome de classe válido') . ' (' . $xml->controller . ').';
			} else if(class_exists($xml->controller)) {
				$return['controller'] = lang('<strong>Dados do módulo:</strong> já existe um controlador com o nome informado no nodo <strong>&lt;controller&gt;&lt;/controller&gt;</strong>') . ' (' . $xml->controller . ').';
			}
			
			// ROTULE
			if($xml->rotule == '')
			{
				$return['rotule'] = lang('<strong>Dados do módulo:</strong> nodo <strong>&lt;rotule&gt;&lt;/rotule&gt;</strong> não está presente ou seu conteúdo está vazio.');
			}
			
			// ITEMS_PER_PAGE
			if($xml->items_per_page != '' && $this->validation->is_integer_($xml->items_per_page) == false)
			{
				$return['items_per_page'] = lang('<strong>Dados do módulo:</strong> nodo <strong>&lt;items_per_page&gt;&lt;/items_per_page&gt;</strong> caso informado deve conter um valor numérico.');
			}
			
			// MENU DE ACESSO AO MODULO
			if(strtolower($xml->menu_access->create_menu) != 'true' && strtolower($xml->menu_access->create_menu) != 'false')
			{
				$return['menu_access']['create_menu'] = lang('<strong>Menu de acesso ao módulo:</strong> nodo <strong>&lt;create_menu&gt;&lt;/create_menu&gt;</strong> não está presente ou o valor informado é diferente de true/false.');
			}
			
			// MENU DE ACESSO AO MODULO: APLICAR PARA GRUPOS (utilizar @ pois o nodo pode não existir)
			// QUANDO É SUB-NODO TEM DE FAZER CONVERSÃO PARA STRING, POIS SE TESTAR COM != null o objeto PAI PREVALECE
			if((string) $xml->menu_access->apply_to_groups != '')
			{
				if($xml->menu_access->apply_to_groups->group->count() > 0)
				{
					// Variavel de teste de grupos que falharam
					$groups_fail = '';
					
					// Verifica a existencia dos grupos informados (palavra de grupo reservado: none
					foreach($xml->menu_access->apply_to_groups->children() as $idx => $group)
					{
						$query = $this->db->get_where('acm_user_group', "name LIKE '" .  $this->db->escape_like_str(trim($group)) . "'");
						$groups_fail .= ($query->num_rows() <= 0) ? $group . ', ' : '';
					}
					
					// Grupos inexistentes no banco
					$groups_fail = trim(trim($groups_fail), ',');
					if($groups_fail != '')
					{
						$return['menu_access']['apply_to_groups'] = lang('<strong>Menu de acesso ao módulo:</strong> nodo <strong>&lt;apply_to_groups&gt;&lt;/apply_to_groups&gt;</strong> contém grupos informados inexistentes') . ' (Grupo(s): ' . $groups_fail . ').';
					}
				}
			}
		
			// FORMULÁRIOS (utilizar @ pois o nodo pode não existir)
			if($xml->forms != null)
			{
				if(@$xml->forms->children()->count() > 0)
				{
					$arr_forms = array('insert', 'update', 'delete', 'view');
					foreach($arr_forms as $form)
					{
						if(strtolower($xml->forms->{$form}) != 'true' && strtolower($xml->forms->{$form}) != 'false')
						{
							$return['forms'][$form] = lang("<strong>Formulários:</strong> nodo <strong>&lt;$form&gt;&lt;/$form&gt;</strong> não está presente ou o valor informado é diferente de true/false.");
						}					
					}
				} else {
					$return['forms'] = lang('<strong>Formulários:</strong> nodo <strong>&lt;forms&gt;&lt;/forms&gt;</strong> não está presente ou seu conteúdo está vazio.');
				}
			}
			
			// PERMISSÕES
			if($xml->permissions->permission != null)
			{
				if(@$xml->permissions->permission->count() > 0)
				{
					$count = $xml->permissions->permission->count();
					for($i = 0; $i < $count; $i++)
					{
						// Name da permissão
						if($xml->permissions->permission[$i]->name == '' )
						{
							$return['permissions']['name'][$i] = lang("<strong>Permissões:</strong> nodo <strong>&lt;name&gt;&lt;/name&gt;</strong> não está presente ou seu conteúdo está vazio.");
						} else if(preg_match('/^[a-zA-Z0-9_.]+$/', $xml->permissions->permission[$i]->name) == false) {
							$return['permissions']['name'][$i] = lang("<strong>Permissões:</strong> nodo <strong>&lt;name&gt;&lt;/name&gt;</strong> valor informado deve conter apenas letras, números, ponto e caracter underscore '_'.");
						}
						
						// Rótulo da permissão
						if($xml->permissions->permission[$i]->rotule == '' )
						{
							$return['permissions']['rotule'][$i] = lang("<strong>Permissões:</strong> nodo <strong>&lt;rotule&gt;&lt;/rotule&gt;</strong> não está presente ou seu conteúdo está vazio.");
						}
						
						// Descrição da permissão
						if($xml->permissions->permission[$i]->description == '' )
						{
							$return['permissions']['description'][$i] = lang("<strong>Permissões:</strong> nodo <strong>&lt;description&gt;&lt;/description&gt;</strong> não está presente ou seu conteúdo está vazio.");
						}
					}
				}
			}
			
			// ACTIONS
			if($xml->actions->action != null)
			{
				if(@$xml->actions->action->count() > 0)
				{
					$count = $xml->actions->action->count();
					for($i = 0; $i < $count; $i++)
					{
						// Rótulo do action
						if($xml->actions->action[$i]->rotule == '' )
						{
							$return['actions']['rotule'][$i] = lang("<strong>Ações de registro de módulo:</strong> nodo <strong>&lt;rotule&gt;&lt;/rotule&gt;</strong> não está presente ou seu conteúdo está vazio.");
						}
						
						// Description do action
						if($xml->actions->action[$i]->description == '' )
						{
							$return['actions']['description'][$i] = lang("<strong>Ações de registro de módulo:</strong> nodo <strong>&lt;description&gt;&lt;/description&gt;</strong> não está presente ou seu conteúdo está vazio.");
						}
						
						// Link do action
						if($xml->actions->action[$i]->link == '' )
						{
							$return['actions']['link'][$i] = lang("<strong>Ações de registro de módulo:</strong> nodo <strong>&lt;link&gt;&lt;/link&gt;</strong> não está presente ou seu conteúdo está vazio.");
						}
					}
				}
			}
			
			// MENUS
			if($xml->menus->menu != null)
			{
				if($xml->menus->menu->count() > 0)
				{
					$count = $xml->menus->menu->count();
					for($i = 0; $i < $count; $i++)
					{
						// Rótulo do menu
						if($xml->menus->menu[$i]->rotule == '' )
						{
							$return['menus']['rotule'][$i] = lang("<strong>Menus do módulo:</strong> nodo <strong>&lt;rotule&gt;&lt;/rotule&gt;</strong> não está presente ou seu conteúdo está vazio.");
						}
						
						// Description do menu
						if($xml->menus->menu[$i]->description == '' )
						{
							$return['menus']['description'][$i] = lang("<strong>Menus do módulo:</strong> nodo <strong>&lt;description&gt;&lt;/description&gt;</strong> não está presente ou seu conteúdo está vazio.");
						}
						
						// Link do menu
						if($xml->menus->menu[$i]->link == '' )
						{
							$return['menus']['link'][$i] = lang("<strong>Menus do módulo:</strong> nodo <strong>&lt;link&gt;&lt;/link&gt;</strong> não está presente ou seu conteúdo está vazio.");
						}
					}
				}
			}
			
			// DEBUG:
			// print_r($return);
			
		} catch(Exception $e) {
			// Varre erros de estrutura mapeados no arquivo
			$msg = '';
			foreach(libxml_get_errors() as $error) 
			{
				$msg .= "<br />" . $error->message;
			}
			$this->error->show_exception_page(lang('Arquivo') . ' <strong>' . $file_name . '</strong> ' . lang('contém erros em seu formato. Verifique o conteúdo do arquivo e tente novamente. Caso persistam os problemas, leia sobre a formatação de arquivos <strong>.xml</strong>.<br /><br /><strong>Detalhes do problema:</strong> ') . $msg, URL_ROOT . '/acme_maker/new_module/' . basename($file_name));
		}
		
		// Corrige retorno (caso array não tenha sido preenchido 
		// em nenhum lugar, então não ocorreram erros)
		if(count($return) <= 0)
		{
			unset($return);
			$return = true;
		}
		
		// Retorno ajustado
		return $return;
	}
	
	/**
	* _analyze_table()
	* Analisa uma tabela de nome encaminhado, validando se ela está de acordo com as regras 
	* necessárias de construção de um módulo. Retorna true caso a tabela seja valida, caso
	* contrário retorna false. Estas regras são:
	* -> tabela só pode conter uma única coluna como sendo chave primária.
	* @param string table
	* @return boolean status
	*/
	public function _analyze_table($table = '')
	{
		$return = false;
		if($this->db->table_exists($table))
		{
			$fields = $this->db->field_data($table);
			$count_pks = 0;
			foreach ($fields as $field)
			{
				if($field->primary_key == 1)
				{
					$count_pks++;
				}
			}
			$return = ($count_pks > 1 || $count_pks < 1) ? false : true;
		}
		
		return $return;
	}
	
	/**
	* _process_module_file()
	* Processa o arquivo de configuração encaminhado, retornando um array pronto para ser 
	* 'inserido' no banco de dados. Deve ser utilizado após a validação através do método
	* _analyze_module_file. Leva em consideração o método atual de processamento de arquivo.
	* @param string file_name
	* @return array data
	*/
	public function _process_module_file($file_name = '')
	{
		switch(strtolower($this->file_method_process))
		{
			case 'ini':
				return $this->_process_module_file_ini($file_name);
			break;
			
			case 'xml':
			default:
				return $this->_process_module_file_xml($file_name); 
			break;
		}
	}
	
	/**
	* _process_module_file_ini()
	* Processa o arquivo de configuração encaminhado com base em layout de arquivos em formato .ini
	* @param string file_name
	* @return array data
	*/
	public function _process_module_file_ini($file_name = '')
	{
		// Inicializa Variável de erro/retorno
		$return = array();
		
		// Abre o arquivo, le e parse no conteudo
		$file = file_get_contents($file_name);
		$content = parse_ini_string($file, true);
		
		// Dados do módulo
		$return['module']['table'] = get_value(get_value($content, 'module'), 'table');
		$return['module']['controller'] = get_value(get_value($content, 'module'), 'controller');
		$return['module']['rotule'] = get_value(get_value($content, 'module'), 'rotule');
		$return['module']['sql_list'] = get_value(get_value($content, 'module'), 'sql_list');
		$return['module']['items_per_page'] = get_value(get_value($content, 'module'), 'items_per_page');
		$return['module']['url_img'] = get_value(get_value($content, 'module'), 'url_img');
		$return['module']['description'] = get_value(get_value($content, 'module'), 'description');
		
		// Dados de link para o modulo
		$return['link_to_module']['use_menu'] = get_value(get_value($content, 'link_to_module'), 'use_menu');
		$return['link_to_module']['apply_groups'] = get_value(get_value($content, 'link_to_module'), 'apply_groups');
		
		// Dados de formularios
		$return['forms']['insert'] = get_value(get_value($content, 'forms'), 'insert');
		$return['forms']['update'] = get_value(get_value($content, 'forms'), 'update');
		$return['forms']['delete'] = get_value(get_value($content, 'forms'), 'delete');
		$return['forms']['view'] = get_value(get_value($content, 'forms'), 'view');
		
		// Dados de permissões
		$return['permissions']['insert'] = get_value(get_value($content, 'permissions'), 'insert');
		$return['permissions']['update'] = get_value(get_value($content, 'permissions'), 'update');
		$return['permissions']['delete'] = get_value(get_value($content, 'permissions'), 'delete');
		$return['permissions']['view'] = get_value(get_value($content, 'permissions'), 'view');
		$return['permissions']['enter'] = get_value(get_value($content, 'permissions'), 'enter');
		$return['permissions']['custom'] = array();
		
		// Dados de ações
		$return['actions']['update'] = get_value(get_value($content, 'actions'), 'update');
		$return['actions']['delete'] = get_value(get_value($content, 'actions'), 'delete');
		$return['actions']['view'] = get_value(get_value($content, 'actions'), 'view');
		$return['actions']['custom'] = array();
		
		// Dados de menus
		$return['menus']['insert'] = get_value(get_value($content, 'menus'), 'insert');
		$return['menus']['custom'] = array();
		
		// Customizados (actions, menus e permissions)
		foreach($content as $key => $value)
		{
			// Menus customizados
			if(preg_match_all('/^custom_menu[\s]*[:][\w\d\s]*/i', $key, $matches))
			{
				foreach($matches[0] as $pos => $key_menu)
				{
					$return['menus']['custom'][$key_menu] = get_value($content, $key_menu);
				}
			}
			
			// Actions customizados
			if(preg_match_all('/^custom_action[\s]*[:][\w\d\s]*/i', $key, $matches))
			{
				foreach($matches[0] as $pos => $key_action)
				{
					$return['actions']['custom'][$key_action] = get_value($content, $key_action);
				}
			}
			
			// Permissions customizados
			if(preg_match_all('/^custom_permission[\s]*[:][\w\d\s]*/i', $key, $matches))
			{
				foreach($matches[0] as $pos => $key_permission)
				{
					$return['permissions']['custom'][$key_permission] = get_value($content, $key_permission);
				}
			}
		}
		
		return $return;
	}
	
	/**
	* _process_module_file_xml()
	* Processa o arquivo de configuração encaminhado com base em layout de arquivos em formato .xml
	* @param string file_name
	* @return array data
	*/
	public function _process_module_file_xml($file_name = '')
	{
		// Inicializa Variável de erro/retorno
		$return = array();
		
		$xml = @new SimpleXMLElement(file_get_contents($file_name));
		
		// DADOS DO MÓDULO
		$return['table'] = (string) $xml->table;
		$return['controller'] = (string) $xml->controller;
		$return['rotule'] = (string) $xml->rotule;
		$return['description'] = (string) $xml->description;
		$return['sql_list'] = (string) $xml->sql_list;
		$return['items_per_page'] = (string) $xml->items_per_page;
		$return['url_img'] = (string) $xml->url_img;
		
		// MENU DE ACESSO AO MODULO
		$return['menu_access']['create_menu'] = (string) $xml->menu_access->create_menu;
		$return['menu_access']['apply_to_groups'] = ((string) $xml->menu_access->apply_to_groups != '') ? $xml->menu_access->apply_to_groups->children() : array();
		
		// FORMULÁRIOS
		$arr_forms = array('insert', 'update', 'delete', 'view');
		foreach($arr_forms as $form)
		{
			$return['forms'][$form] = (string) $xml->forms->{$form};					
		}
		
		// PERMISSÕES
		$return['permissions'] = array();
		if($xml->permissions->permission != null)
		{
			if(@$xml->permissions->permission->count() > 0)
			{
				$count = $xml->permissions->permission->count();
				for($i = 0; $i < $count; $i++)
				{
					$return['permissions'][$i]['name'] = (string) $xml->permissions->permission[$i]->name;
					$return['permissions'][$i]['rotule'] = (string) $xml->permissions->permission[$i]->rotule;
					$return['permissions'][$i]['description'] = (string) $xml->permissions->permission[$i]->description;
				}
			}
		}
		
		// ACTIONS
		$return['actions'] = array();
		if($xml->actions->action != null)
		{		
			if(@$xml->actions->action->count() > 0)
			{
				$count = $xml->actions->action->count();
				for($i = 0; $i < $count; $i++)
				{
					$return['actions'][$i]['link'] = (string) $xml->actions->action[$i]->link;
					$return['actions'][$i]['rotule'] = (string) $xml->actions->action[$i]->rotule;
					$return['actions'][$i]['description'] = (string) $xml->actions->action[$i]->description;
					$return['actions'][$i]['target'] = (string) $xml->actions->action[$i]->target;
					$return['actions'][$i]['javascript'] = (string) $xml->actions->action[$i]->javascript;
					$return['actions'][$i]['url_img'] = (string) $xml->actions->action[$i]->url_img;
					$return['actions'][$i]['order'] = (string) $xml->actions->action[$i]->order;
				}
			}
		}
		
		// MENUS
		$return['menus'] = array();
		if($xml->menus->menu != null)
		{
			if(@$xml->menus->menu->count() > 0)
			{
				$count = $xml->menus->menu->count();
				for($i = 0; $i < $count; $i++)
				{
					$return['menus'][$i]['link'] = (string) $xml->menus->menu[$i]->link;
					$return['menus'][$i]['rotule'] = (string) $xml->menus->menu[$i]->rotule;
					$return['menus'][$i]['description'] = (string) $xml->menus->menu[$i]->description;
					$return['menus'][$i]['target'] = (string) $xml->menus->menu[$i]->target;
					$return['menus'][$i]['javascript'] = (string) $xml->menus->menu[$i]->javascript;
					$return['menus'][$i]['url_img'] = (string) $xml->menus->menu[$i]->url_img;
					$return['menus'][$i]['order'] = (string) $xml->menus->menu[$i]->order;
				}
			}
		}
		
		// Retorno ajustado
		return $return;
	}
	
	/**
	* _create_module()
	* Cria um módulo com base em um nome de arquivo de módulo (.ini) encaminhado.
	* @param string file_name
	* @return boolean status
	*/
	public function _create_module($file_name = '')
	{
		// Carrega camada modelo do engine
		// $this->load->model('core/engine_model');
		
		// Coleta dados do arquivo
		$content = $this->_process_module_file($file_name);
		$file_string = file_get_contents($file_name);
		
		// Variaveis de controle para criação de permissões, actions e menus automáticos
		$automatic_menus_created = array();
		$automatic_actions_created = array();
		$automatic_permissions_created = array();
		
		// INICIALIZA VARIAVEIS DE ORDENAÇÃO PARA MENUS E ACTIONS
		$count_order_menus = 5;
		$count_order_actions = 5;
		
		// Inicia bloco de transação
		$this->db->trans_start();
		
		// ---------------------------
		// INSERÇÃO DE DADOS DO MÓDULO
		// ---------------------------
		// Insere dados do módulo
		$module['ini_file'] = $file_string;
		$module['table'] = get_value($content, 'table');
		$module['controller'] = get_value($content, 'controller');
		$module['lang_key_rotule'] = get_value($content, 'rotule');
		$module['sql_list'] = get_value($content, 'sql_list');
		$module['items_per_page'] = (get_value($content, 'items_per_page') == '') ? 100 : get_value($content, 'items_per_page');
		$module['url_img'] = get_value($content, 'url_img');
		$module['description'] = get_value($content, 'description');
		
		foreach($module as $column => $value)
		{
			if($value == '')
			{
				$escape = false;
				$value = 'NULL';
			} else {
				$escape = true;
			}
			$this->db->set($column, $value, $escape);
		}
		
		// Faz o insert e coleta o id inserido
		$this->db->insert('acm_module');
		$id_module = $this->db->insert_id();
		
		// ----------------------------
		// PERMISSÃO DE ENTRADA (ENTER)
		// ----------------------------
		$permission['id_module'] = $id_module;
		$permission['lang_key_rotule'] = 'Permissão de entrada do módulo';
		$permission['description'] = 'Esta permissão é testada quando este módulo é acessado.';
		$permission['permission'] = 'enter';
		$this->db->insert('acm_module_permission', $permission);
		$automatic_permissions_created[] = 'enter';
		
		// ---------------------------
		// MENU DE ACESSO AO MÓDULO
		// ---------------------------
		if(strtolower(get_value($content['menu_access'], 'create_menu')) == 'true')
		{
			// Menu recebe o nome do modulo
			$menu_access['lang_key_rotule'] = get_value($content, 'rotule');
			$menu_access['link'] = '<acme eval="URL_ROOT"/>/' . get_value($content, 'controller');
			
			// Faz insert de menu para cada grupo informado
			// Divide a lista de grupos
			foreach(get_value($content['menu_access'], 'apply_to_groups') as $group)
			{
				$query = $this->db->get_where('acm_user_group', "name LIKE '$group'");
				$data = $query->row();
				$menu_access['id_user_group'] = $data->id_user_group;
				// Faz o insert para o grupo atual
				$this->db->insert('acm_menu', $menu_access);
			}
		}
		
		// ----------------------------------------------------------
		// INSERÇÃO DE FORMULÁRIOS (somente se tabela estiver setada)
		// ----------------------------------------------------------
		if(get_value($content, 'table') != '')
		{
			// Verifica se algum formulário deverá ser preenchido para coletar dados 
			// dos campos da tabela (e rodar somente uma vez a consulta)
			if(strtolower(get_value($content['forms'], 'insert')) == 'true' || strtolower(get_value($content['forms'], 'update')) == 'true' || strtolower(get_value($content['forms'], 'delete')) == 'true' || strtolower(get_value($content['forms'], 'view')) == 'true')
			{
				$fields = $this->db->field_data(get_value($content, 'table'));
				foreach ($fields as $field)
					$form_fields[] = $this->form->build_array_field_db_from_object($field, get_value($content, 'table'));
			}
			
			// INSERÇÃO, UPDATE, DELETE, VIEW (array contendo booleanos de configuracao
			// de criação automática de registros extras para cada tipo de operação)
			$arr_forms[] = array('name' => 'insert', 
								  'rotule' =>'Inserção',
								  'create_automatic_menu' => true,
								  'create_automatic_action' => false,
								  'create_automatic_permission' => true,
								  );
			$arr_forms[] = array('name' => 'update', 
								  'rotule' =>'Edição',
								  'create_automatic_menu' => false,
								  'create_automatic_action' => true,
								  'create_automatic_permission' => true,
								  );
			$arr_forms[] = array('name' => 'delete', 
								  'rotule' =>'Deleção',
								  'create_automatic_menu' => false,
								  'create_automatic_action' => true,
								  'create_automatic_permission' => true,
								  );
			$arr_forms[] = array('name' => 'view', 
								  'rotule' =>'Visualização',
								  'create_automatic_menu' => false,
								  'create_automatic_action' => true,
								  'create_automatic_permission' => true,
								  );
			// PARA CADA ITEM DE FORMULARIO, CRIA O FORMULARIO E DEPENDENDO DA AÇÃO,
			// CRIA TAMBÉM PERMISSÕES, MENUS E ACTIONS
			for($i = 0; $i < count($arr_forms); $i++)
			{
				if(get_value($content['forms'], $arr_forms[$i]['name']) == 'true')
				{
					$form['id_module'] = $id_module;
					$form['operation'] = $arr_forms[$i]['name'];
					$this->db->insert('acm_module_form', $form);
					
					// Insere campos para este formulário
					$id_form = $this->db->insert_id();
					
					// Varre os campos, setando o id_form deles
					$count_fields = count($form_fields);
					for($f = 0; $f < $count_fields; $f++)
					{
						$form_fields[$f]['id_module_form'] = $id_form;
						foreach($form_fields[$f] as $column_form => $value_form)
						{
							// echo $value_form . '<br />';
							$escape = ($value_form == 'NULL') ? false : true;
							$this->db->set($column_form, $value_form, $escape);
						}
						$this->db->insert('acm_module_form_field');
					}
					
					// Insert de permissão automática
					if($arr_forms[$i]['create_automatic_permission'])
					{
						$permission['id_module'] = $id_module;
						$permission['lang_key_rotule'] = 'Permissão de ' . $arr_forms[$i]['rotule'];
						$permission['description'] = 'Esta permissão é testada quando a operação de ' . $arr_forms[$i]['rotule'] . ' é invocada através de uma página de formulário.';
						$permission['permission'] = $arr_forms[$i]['name'];
						$this->db->insert('acm_module_permission', $permission);
						
						// Seta em array de controle que a permissão da ação atual foi criada
						// Isso será utilizado posteriormente caso uma permissão de mesmo nome seja
						// definida manualmente
						$automatic_permissions_created[] = $arr_forms[$i]['name'];
					}
					
					// Insert de ação de registro automática
					if($arr_forms[$i]['create_automatic_action'])
					{
						$action['id_module'] = $id_module;
						$action['lang_key_rotule'] = $arr_forms[$i]['rotule'];
						$action['description'] = 'Esta ação de registro aponta seu link para o formulário de ' . $arr_forms[$i]['rotule'] . '.';
						$action['link'] = '<acme eval="URL_ROOT"/>/' . get_value($content, 'controller') . '/form/' . $arr_forms[$i]['name'] . '/{0}';
						$action['url_img'] = '<acme eval="URL_IMG"/>/icon_' . $arr_forms[$i]['name'] . '.png';
						$action['order'] = $count_order_actions;
						$this->db->insert('acm_module_action', $action);
						
						// Seta em array de controle que a ação da ação atual foi criada, isso será 
						// utilizado posteriormente caso uma permissão de mesmo nome seja definida 
						// manualmente
						$automatic_actions_created[] = $arr_forms[$i]['name'];
						
						// Incrementa a ordenação
						$count_order_actions += 5;
					}
					
					// Insert de menu automático
					if($arr_forms[$i]['create_automatic_menu'])
					{
						$menu['id_module'] = $id_module;
						$menu['lang_key_rotule'] = $arr_forms[$i]['rotule'];
						$menu['description'] = 'Este menu aponta seu link para o formulário de ' . $arr_forms[$i]['rotule'] . '.';
						$menu['link'] = '<acme eval="URL_ROOT"/>/' . get_value($content, 'controller') . '/form/' . $arr_forms[$i]['name'];
						$menu['url_img'] = '<acme eval="URL_IMG"/>/icon_' . $arr_forms[$i]['name'] . '.png';
						$menu['order'] = $count_order_menus;
						$this->db->insert('acm_module_menu', $menu);
						
						// Seta em array de controle que a ação da ação atual foi criada, isso será 
						// utilizado posteriormente caso uma permissão de mesmo nome seja definida 
						// manualmente
						$automatic_menus_created[] = $arr_forms[$i]['name'];
						
						// Incrementa a ordenação
						$count_order_menus += 5;
					}
				}
			}
		}
		
		// ----------------------
		// INSERÇÃO DE PERMISSÕES
		// ----------------------
		for($i = 0; $i < count($content['permissions']); $i++)
		{
			if(!in_array($content['permissions'][$i]['name'], $automatic_permissions_created))
			{
				$permission['id_module'] = $id_module;
				$permission['lang_key_rotule'] = $content['permissions'][$i]['rotule'];
				$permission['description'] = $content['permissions'][$i]['description'];
				$permission['permission'] = $content['permissions'][$i]['name'];
				$this->db->insert('acm_module_permission', $permission);
				
				// Adiciona permissão atual, para que não seja re-inserida
				$automatic_permissions_created[] = $content['permissions'][$i]['name'];
			}
		}
		
		// ----------------------
		// INSERÇÃO DE AÇÕES
		// ----------------------
		for($i = 0; $i < count($content['actions']); $i++)
		{
			$action['id_module'] = $id_module;
			$action['lang_key_rotule'] = $content['actions'][$i]['rotule'];
			$action['description'] = $content['actions'][$i]['description'];
			$action['link'] = $content['actions'][$i]['link'];
			$action['target'] = $content['actions'][$i]['target'];
			$action['javascript'] = $content['actions'][$i]['javascript'];
			$action['url_img'] = $content['actions'][$i]['url_img'];
			$action['order'] = ($content['actions'][$i]['order'] == '') ? $count_order_actions + 5 : $content['actions'][$i]['order'];
			$this->db->insert('acm_module_action', $action);
			
			// Incrementa ordenação
			$count_order_actions += 5;
		}
		
		// ----------------------
		// INSERÇÃO DE MENUS
		// ----------------------
		for($i = 0; $i < count($content['menus']); $i++)
		{
			$menu['id_module'] = $id_module;
			$menu['lang_key_rotule'] = $content['menus'][$i]['rotule'];
			$menu['description'] = $content['menus'][$i]['description'];
			$menu['link'] = $content['menus'][$i]['link'];
			$menu['target'] = $content['menus'][$i]['target'];
			$menu['javascript'] = $content['menus'][$i]['javascript'];
			$menu['url_img'] = $content['menus'][$i]['url_img'];
			$menu['order'] = ($content['menus'][$i]['order'] == '') ? $count_order_menus + 5 : $content['menus'][$i]['order'];
			$this->db->insert('acm_module_menu', $menu);
			
			// Incrementa ordenação
			$count_order_menus += 5;
		}	
		
		// -----------------------------
		// CRIAÇÃO DE ARQUIVOS DO MÓDULO
		// -----------------------------
		// Controlador
		$file_controller = file_get_contents('application/core/acme/engine_files/maker_template_controller.php');
		$file_controller = str_replace('<CLASS_NAME>', get_value($content, 'controller'), $file_controller);
		$file_controller = str_replace('<MODULE_DESCRIPTION>', get_value($content, 'description'), $file_controller);
		$file_controller = str_replace('<CREATION_DATE>', date('d/m/Y'), $file_controller);
		file_put_contents('application/controllers/' . get_value($content, 'controller') . '.php', $file_controller);
		
		// Model
		$file_model = file_get_contents('application/core/acme/engine_files/maker_template_model.php');
		$file_model = str_replace('<CLASS_NAME>', get_value($content, 'controller'), $file_model);
		$file_model = str_replace('<MODULE_DESCRIPTION>', get_value($content, 'description'), $file_model);
		$file_model = str_replace('<CREATION_DATE>', date('d/m/Y'), $file_model);
		file_put_contents('application/models/' . get_value($content, 'controller') . '_model.php', $file_model);
		
		// View
		@mkdir('application/views/' . TEMPLATE . '/' . get_value($content, 'controller'));
		
		// Fecha a transação
		$this->db->trans_complete();
		
		return true;
	}
	
	/**
	* _get_skeleton_module_file()
	* Retorna o conteúdo (string) do arquivo esqueleto de configuração de módulo. Parametro
	* diz qual estrutura de arquivo deverá ser copiada.
	* @return string content_file
	*/
	public function _get_skeleton_module_file($method = '')
	{
		switch(strtolower($method))
		{
			case 'ini':
				return file_get_contents('application/core/acme/engine_files/maker_template_module_file.ini');
			break;
			
			case 'xml':
			default:
				return file_get_contents('application/core/acme/engine_files/maker_template_module_file.xml');
			break;
		}
	}
	
	/**
	* _get_skeleton_custom_section()
	* Retorna o conteúdo (string) de uma seção custom de arquivo esqueleto de configuração de módulo.
	* @param string section
	* @return string content_file
	*/
	public function _get_skeleton_custom_section($section)
	{
		$content = '';
		switch(strtolower($section))
		{
			case 'menu':
			case 'action':
			case 'permission':
				$content = file_get_contents('application/core/acme/engine_files/maker_template_module_file_custom_' . $section . '.ini');
			break;
			
			default:
			break;
		}
		return $content;
	}
	
	
	
	// ------------------------------------------------------------------------------------------
	// CONJUNTO DE FUNÇÕES DO MOTOR DE ACME ENGINE UTILIZADAS NO MÓDULO DE ATUALIZAÇÃO DE APP.
	// ------------------------------------------------------------------------------------------
	// application/controllers/acme/acme_updater => Módulo responsável pela atualização do
	// sistema ACME através do uso de pacotes de atualização. O conjunto de funções abaixo 
	// contemplam validações dos requisitos de um pacote de atualização, verificação de integridade
	// e afins. Para maiores detalhes sobre a construção de pacotes de atualização, leia a 
	// documentação da classe.
	// 
	// $this->_check_updater_permissions()
	// Verifica as permissões necessárias para o modulo updater funcionar.
	// 
	// $this->_check_updater_requirements()
	// Analisa os requisitos necessarios para o updater funcionar, como bibliotecas padrão.
	// 
	// $this->_analyze_package_update()
	// Analisa a integridade e valida um pacote de atualização.
	// 
	// $this->_process_package_update()
	// Processa um pacote de atualização anteriormente verificado, retornando os dados do pacote
	// em formato de array, já tratado.
	// 
	// $this->_install_package_update()
	// Instala um pacote de nome encaminhado. Pacote deve estar verificado. Processa o pacote
	// no interior desta função.
	// ------------------------------------------------------------------------------------------
	/**
	* _check_updater_permissions()
	* Checa as permissões necessárias para o updater funcionar. Retorna true caso permissions ok 
	* ou false, caso falta de permissao.
	* @return boolean status
	*/
	public function _check_updater_permissions()
	{
		if(is_writable('application/uploads/acme/packages_update') === false && is_readable('application/uploads/acme/packages_update') === false) {
			return false;
		} else if(is_writable('application/temp/acme') === false && is_readable('application/tem/acme') === false) {
			return false;
		} else if(file_exists('application/core/acme/engine_files/updater_template_acme_version.php') === false) {
			return false;
		} else {
			return true;
		}
	}
	
	/**
	* _check_updater_requirements()
	* Checa os requisitos necessários para o updater funcionar. Retorna true caso requirements ok
	* ou array de mensagem de erros, caso erro.
	* @return mixed status/array
	*/
	public function _check_updater_requirements()
	{
		$return = array();
		
		// Extensão zlib
		if(!extension_loaded('zip'))
			$return['zip_extension'] = lang('Extensão zip não carregada em seu PHP. Você deve ativar o uso desta extensão para que este módulo funcione corretamente.');
		
		// Corrige retorno (caso array não tenha sido preenchido 
		// em nenhum lugar, então não ocorreram erros)
		if(count($return) <= 0)
		{
			unset($return);
			$return = true;
		}
		
		// Retorno ajustado
		return $return;
	}
	
	/**
	* _analyze_package_update()
	* Analisa um pacote de atualização, retornando um array de dados sobre este determinado pacote.
	* Verifica a integridade geral do pacote, se tags estão presentes, atributos faltando, etc.
	* @param string file_name
	* @return mixed status/array
	*/
	public function _analyze_package_update($file_name = '')
	{
		// Inicializa Variável de erro/retorno
		$return = array();
		
		// Inicializa objeto de manipulacao zip
		$zip = new ZipArchive();
		
		// Faz abertura do zip do pacote
		$zip->open($file_name);
		
		// Coleta todos os aquivos do zip
		for($i = 0; $i < $zip->numFiles; $i++)
		{ 
			$stat = $zip->statIndex($i);
			$files[] = basename($stat['name']);
		}
		
		// Verifica se existe um arquivo chamado package e outro chamado hash.md5
		if(!in_array('package.zip', $files) && !in_array('hash.md5', $files))
		{
			$return['bad-package'] = lang('Conteúdo do pacote: arquivos faltando no conteúdo total do pacote.');
		} else {
			// Extrai o conteúdo do pacote para diretório temporário
			$temp_dir = 'application/temp/acme/' . uniqid();
			$zip->extractTo($temp_dir);
			
			// Agora trabalha com diretório, não mais com pacote
			// Verifica a integridade do pacote (com base no md5 do arquivo interno)
			if(md5_file($temp_dir . '/package.zip') != file_get_contents($temp_dir . '/hash.md5'))
			{
				$return['bad-package'] = lang('Conteúdo do pacote: pacote de atualização corrompido.');
			} else {
				// Abre o pacote interno, contendo o conteúdo novo do pacote
				$package_file = $temp_dir . '/package.zip';
				$zip_package = new ZipArchive();
				$zip_package->open($package_file);
				
				// Coleta todos os aquivos do zip interno
				for($i = 0; $i < $zip_package->numFiles; $i++)
				{ 
					$stat = $zip_package->statIndex($i);
					$package_files[] = basename($stat['name']);
				}
				
				// Verifica se existe arquivo install.xml
				if(!in_array('install.xml', $package_files))
				{
					$return['bad-package'] = lang('Conteúdo do pacote: install.xml não está presente no interior do pacote.');
				} else {
					// Descompacta pacote interno e analisa o install.xml
					$zip_package->extractTo($temp_dir . '/package');
					
					// Seta o file path do install.xml
					$file_xml = $temp_dir . '/package/install.xml';
					
					// Analisa o XML de instalação
					try {
						// Seta mapeamento de erros internos e em seguida Analisa o 
						// arquivo (verifica tags obrigatórias e seu conteudo)
						libxml_use_internal_errors(true);
						$xml = @new SimpleXMLElement(file_get_contents($file_xml));
						
						// CHAVE DE IDENTIFICAÇÃO DO PACOTE
						// Verifica valor informado, caso não exista o pacote é inválido.
						// Caso valor exista, verifica se pacote já está instalado no sistema
						if($xml->{'package-version'}->count() <= 0 || $xml->{'package-version'}->attributes()->value == '')
							$return['package-version'] = lang('Versão de atualização do pacote: valor não informado.');
						
						// CHAVE DE IDENTIFICAÇÃO DO PACOTE PAI (valida somente existencia)
						if($xml->{'package-version-father'}->count() <= 0)
							$return['package-version-father'] = lang('Versão de atualização do pacote pai: valor não obrigatório, porém tag não está presente.');
						
						// NOME DO PACOTE DE ATUALIZAÇÃO
						if($xml->{'package-name'}->count() <= 0 || $xml->{'package-name'}->attributes()->value == '')
							$return['package-name'] = lang('Nome do pacote: valor não informado.');
						
						// DATA DE DISPONIBILIZAÇÃO DO PACOTE
						if($xml->{'package-dtt-available'}->count() <= 0 || $xml->{'package-dtt-available'}->attributes()->value == '')
							$return['package-dtt-available'] = lang('Data de disponibilização do pacote: valor não informado.');
						
						// DESCRIÇÃO DO PACOTE DE ATUALIZAÇÃO
						if($xml->{'package-description'}->count() <= 0 || $xml->{'package-description'} == '')
							$return['package-description'] = lang('Descrição do pacote: valor não informado.');
						
						// AÇÕES DO PACOTE DE ATUALIZAÇÃO
						if(count(@(array)$xml->{'package-actions'}->children()) <= 0 || $xml->{'package-actions'}->count() <= 0)
						{
							$return['package-actions'] = lang('Ações do pacote: nenhuma ação presente no pacote.');
						} else {
							// FAZ AS DEVIDAS VALIDAÇÕES DE AÇÕES (VERIFICA SE ATRIBUTOS ESTÃO PRESENTES, ETC)
							// VALIDAÇÕES PARA SQL - tag <run-sql-file value="sql/example.sql" />
							$count_sql = count($xml->{'package-actions'}->{'run-sql-file'});
							if($count_sql > 0)
							{
								// Inicializa var de controle de retorno de índices com problemas
								$arr_idxs_invalid = '';
								$arr_idxs_file_not_found = '';
								
								// Verifica todas as instruções de run sql
								for($i = 0; $i < $count_sql; $i++)
								{
									if($xml->{'package-actions'}->{'run-sql-file'}[$i]->attributes()->value == '' || $xml->{'package-actions'}->{'run-sql-file'}[$i]->attributes()->order == '')
										$arr_idxs_invalid .= $i . ', ';
									elseif(!file_exists($temp_dir . '/package/' . (string)$xml->{'package-actions'}->{'run-sql-file'}[$i]->attributes()->value))
										$arr_idxs_file_not_found .= $i . ', ';
								}
								
								// Verifica se existe algum índice com problema
								if($arr_idxs_invalid != '')
									$return['run-sql-file'] = lang('Ação SQL: valor ou ordem não informado. Índice(s)') . ' ' . (trim($arr_idxs_invalid, ', ')) . '.';
								elseif($arr_idxs_file_not_found != '')
									$return['run-sql-file'] = lang('Ação SQL: arquivos informados não estão presentes. Índice(s)') . ' ' . (trim($arr_idxs_file_not_found, ', ')) . '.';
							}
							
							// VALIDAÇÕES PARA COPIA DE ARQUIVOS
							// tag <copy-replace-file from="somepath/example" to="application/somepath/example" />
							$count_copy_replace = count($xml->{'package-actions'}->{'copy-replace-file'});
							if($count_copy_replace > 0)
							{
								// Inicializa var de controle de retorno de índices com problemas
								$arr_idxs_invalid = '';
								$arr_idxs_file_not_found = '';
								
								// Verifica todas as instruções de run copia de arquivos
								for($i = 0; $i < $count_copy_replace; $i++)
								{
									if($xml->{'package-actions'}->{'copy-replace-file'}[$i]->attributes()->from == '' || $xml->{'package-actions'}->{'copy-replace-file'}[$i]->attributes()->to == '' || $xml->{'package-actions'}->{'copy-replace-file'}[$i]->attributes()->order == '')
										$arr_idxs_invalid .= $i . ', ';
									elseif(!file_exists($temp_dir . '/package/' . (string)$xml->{'package-actions'}->{'copy-replace-file'}[$i]->attributes()->from))
										$arr_idxs_file_not_found .= $i . ', ';
								}
								
								// Verifica se existe algum índice com problema
								if($arr_idxs_invalid != '')
									$return['copy-replace-file'] = lang('Cópia de arquivos: valor FROM, TO ou ordem não informado. Índice(s)') . ' ' . (trim($arr_idxs_invalid, ', ')) . '.';
								elseif($arr_idxs_file_not_found != '')
									$return['copy-replace-file'] = lang('Cópia de arquivos: arquivo de origem não encontrado no pacote. Índice(s)') . ' ' . (trim($arr_idxs_file_not_found, ', ')) . '.';
							}
							
							// VALIDAÇÕES PARA CRIAÇÃO DE DIRETÓRIOS
							// tag <mkdir value="somepath" />
							$count_mkdir = count($xml->{'package-actions'}->{'mkdir'});
							if($count_mkdir > 0)
							{
								// Inicializa var de controle de retorno de índices com problemas
								$arr_idxs_invalid = '';
								
								// Verifica todas as instruções de criacao de dir
								for($i = 0; $i < $count_mkdir; $i++)
								{
									if($xml->{'package-actions'}->{'mkdir'}[$i]->attributes()->value == '' || $xml->{'package-actions'}->{'mkdir'}[$i]->attributes()->order == '')
										$arr_idxs_invalid .= $i . ', ';
								}
								
								// Verifica se existe algum índice com problema
								if($arr_idxs_invalid != '')
									$return['mkdir'] = lang('Criação de diretórios: valor ou ordem não informado. Índice(s)') . ' ' . (trim($arr_idxs_invalid, ', ')) . '.';
							}
							
							// VALIDAÇÕES PARA REMOÇÃO DE DIRETÓRIOS
							// tag <rmdir value="somepath" />
							$count_rmdir = count($xml->{'package-actions'}->{'rmdir'});
							if($count_rmdir > 0)
							{
								// Inicializa var de controle de retorno de índices com problemas
								$arr_idxs_invalid = '';
								
								// Verifica todas as instruções de remoção
								for($i = 0; $i < $count_rmdir; $i++)
								{
									if($xml->{'package-actions'}->{'rmdir'}[$i]->attributes()->value == '' || $xml->{'package-actions'}->{'rmdir'}[$i]->attributes()->order == '')
										$arr_idxs_invalid .= $i . ', ';
								}
								
								// Verifica se existe algum índice com problema
								if($arr_idxs_invalid != '')
									$return['rmdir'] = lang('Remoção de diretórios: valor ou order não informado. Índice(s)') . ' ' . (trim($arr_idxs_invalid, ', ')) . '.';
							}
							
							// VALIDAÇÕES PARA REMOÇÃO DE ARQUIVOS
							// tag <unlink value="somepath" />
							$count_unlink = count($xml->{'package-actions'}->{'unlink'});
							if($count_unlink > 0)
							{
								// Inicializa var de controle de retorno de índices com problemas
								$arr_idxs_invalid = '';
								
								// Verifica todas as instruções de remoção
								for($i = 0; $i < $count_unlink; $i++)
								{
									if($xml->{'package-actions'}->{'unlink'}[$i]->attributes()->value == '' || $xml->{'package-actions'}->{'unlink'}[$i]->attributes()->order == '')
										$arr_idxs_invalid .= $i . ', ';
								}
								
								// Verifica se existe algum índice com problema
								if($arr_idxs_invalid != '')
									$return['unlink'] = lang('Remoção de arquivos: valor ou order não informado. Índice(s)') . ' ' . (trim($arr_idxs_invalid, ', ')) . '.';
							}
							
							// VALIDAÇÕES PARA RENAME DE ARQUIVOS
							// tag <rename from="somepath/example" to="application/somepath/example" />
							$count_rename = count($xml->{'package-actions'}->{'rename'});
							if($count_rename > 0)
							{
								// Inicializa var de controle de retorno de índices com problemas
								$arr_idxs_invalid = '';
								$arr_idxs_file_not_found = '';
								
								// Verifica todas as instruções de run copia de arquivos
								for($i = 0; $i < $count_rename; $i++)
								{
									if($xml->{'package-actions'}->{'rename'}[$i]->attributes()->from == '' || $xml->{'package-actions'}->{'rename'}[$i]->attributes()->to == '' || $xml->{'package-actions'}->{'rename'}[$i]->attributes()->order == '')
										$arr_idxs_invalid .= $i . ', ';
									elseif(!file_exists((string)$xml->{'package-actions'}->{'rename'}[$i]->attributes()->from))
										$arr_idxs_file_not_found .= $i . ', ';
								}
								
								// Verifica se existe algum índice com problema
								if($arr_idxs_invalid != '')
									$return['rename'] = lang('Renomar arquivo/diretório: valor FROM, TO ou ordem não informado. Índice(s)') . ' ' . (trim($arr_idxs_invalid, ', ')) . '.';
								elseif($arr_idxs_file_not_found != '')
									$return['rename'] = lang('Renomar arquivo/diretório: arquivo de origem não encontrado no sistema. Índice(s)') . ' ' . (trim($arr_idxs_file_not_found, ', ')) . '.';
							}
						}	
					} catch(Exception $e) {
						// Varre erros de estrutura mapeados no arquivo
						$msg = '';
						foreach(libxml_get_errors() as $error) {
							$msg .= "<br />" . $error->message;
						}
						$this->error->show_exception_page(lang('Arquivo XML de instalação de pacote contém erros em seu formato. Verifique o conteúdo do arquivo e tente novamente. Caso persistam os problemas, leia sobre a formatação de arquivos <strong>.xml</strong>.<br /><br /><strong>Detalhes do problema:</strong> ') . $msg, URL_ROOT . '/acme_updater/package_upload/');
					}
					
				}
				
				// Fecha pacote interno
				$zip_package->close();
			}
			
			// Fecha zip externo
			$zip->close();
			
			// Remove o pacote externo e diretório temporário
			$this->load->helper('file');
			@delete_files($temp_dir, true);
			@rmdir($temp_dir);
		}
		
		// Corrige retorno (caso array não tenha sido preenchido 
		// em nenhum lugar, então não ocorreram erros)
		if(count($return) <= 0)
		{
			unset($return);
			$return = true;
		}
		
		// Retorno ajustado
		return $return;
	}
	
	/**
	* _process_package_update()
	* Processa um pacote de atualização, retornando dados deste pacote em um formato ajustado (array).
	* @param string file_name
	* @return array data
	*/
	public function _process_package_update($file_name = '')
	{
		// Inicializa Variável de erro/retorno
		$return = array();
		
		// Inicializa objeto de manipulacao zip
		$zip = new ZipArchive();
		
		// Faz abertura do zip do pacote
		$zip->open($file_name);
		
		// Extrai arquivo para diretório temporário
		$temp_dir = 'application/temp/acme/' . uniqid();
		$zip->extractTo($temp_dir);
		
		// Abre o pacote interno, contendo o conteúdo novo do pacote
		$package_file = $temp_dir . '/package.zip';
		$zip_package = new ZipArchive();
		$zip_package->open($package_file);
		
		// Descompacta pacote interno e analisa o install.xml
		$zip_package->extractTo($temp_dir . '/package');
		
		// Seta o file path do install.xml
		$file_xml = $temp_dir . '/package/install.xml';
		
		// Instancia xml
		$xml = @new SimpleXMLElement(file_get_contents($file_xml));
		
		// version do pacote
		$return['package-version'] = (string)$xml->{'package-version'}->attributes()->value;
		
		// version do pai, caso exista
		$return['package-version-father'] = (string)$xml->{'package-version-father'}->attributes()->value;
		
		// Data de disponibilidade do pacote
		$return['package-dtt-available'] = (string)$xml->{'package-dtt-available'}->attributes()->value;
		
		// Nome do pacote
		$return['package-name'] = (string)$xml->{'package-name'}->attributes()->value;
		
		// Descrição
		$return['package-description'] = (string)$xml->{'package-description'};
		
		// ----------------------------
		// CONJUNTO DE AÇÕES DO PACOTE
		// ----------------------------
		$return['package-actions'] = array();
		
		// AÇÕES DE INSTRUÇÕES SQL
		$count_sql = count($xml->{'package-actions'}->{'run-sql-file'});
		if($count_sql > 0)
		{
			// Verifica todas as instruções de run sql
			for($i = 0; $i < $count_sql; $i++)
			{
				$return['package-actions'][(int)$xml->{'package-actions'}->{'run-sql-file'}[$i]->attributes()->order]['run-sql-file']['file'] = (string)$xml->{'package-actions'}->{'run-sql-file'}[$i]->attributes()->value;
				$return['package-actions'][(int)$xml->{'package-actions'}->{'run-sql-file'}[$i]->attributes()->order]['run-sql-file']['content'] = file_get_contents($temp_dir . '/package/' . (string)$xml->{'package-actions'}->{'run-sql-file'}[$i]->attributes()->value);
			}
		}
		
		// AÇÕES DE CÓPIA/SUBSTITUIÇÃO DE ARQUIVOS
		$count_copy_replace = count($xml->{'package-actions'}->{'copy-replace-file'});
		if($count_copy_replace > 0)
		{
			// Verifica todas as instruções de copia de arquivos
			for($i = 0; $i < $count_copy_replace; $i++)
			{
				$return['package-actions'][(int)$xml->{'package-actions'}->{'copy-replace-file'}[$i]->attributes()->order]['copy-replace-file']['from'] = replace_define_constant((string)$xml->{'package-actions'}->{'copy-replace-file'}[$i]->attributes()->from);
				$return['package-actions'][(int)$xml->{'package-actions'}->{'copy-replace-file'}[$i]->attributes()->order]['copy-replace-file']['to'] = replace_define_constant((string)$xml->{'package-actions'}->{'copy-replace-file'}[$i]->attributes()->to);
			}
		}
		
		// AÇÃO DE CRIAÇÃO DE DIRETÓRIOS
		$count_mkdir = count($xml->{'package-actions'}->{'mkdir'});
		if($count_mkdir > 0)
		{
			// Verifica todas as instruções de criacao
			for($i = 0; $i < $count_mkdir; $i++)
			{
				$return['package-actions'][(int)$xml->{'package-actions'}->{'mkdir'}[$i]->attributes()->order]['mkdir'] = replace_define_constant((string)$xml->{'package-actions'}->{'mkdir'}[$i]->attributes()->value);
			}
		}
		
		// AÇÃO DE REMOÇÃO DE DIRETÓRIOS
		$count_rmdir = count($xml->{'package-actions'}->{'rmdir'});
		if($count_rmdir > 0)
		{
			// Verifica todas as instruções de delecao
			for($i = 0; $i < $count_rmdir; $i++)
			{
				$return['package-actions'][(int)$xml->{'package-actions'}->{'rmdir'}[$i]->attributes()->order]['rmdir'] = replace_define_constant((string)$xml->{'package-actions'}->{'rmdir'}[$i]->attributes()->value);
			}
		}
		
		// AÇÃO DE REMOÇÃO DE ARQUIVOS
		$count_unlink = count($xml->{'package-actions'}->{'unlink'});
		if($count_unlink > 0)
		{
			// Verifica todas as instruções de remocao de arquivos
			for($i = 0; $i < $count_unlink; $i++)
			{
				$return['package-actions'][(int)$xml->{'package-actions'}->{'unlink'}[$i]->attributes()->order]['unlink'] = replace_define_constant((string)$xml->{'package-actions'}->{'unlink'}[$i]->attributes()->value);
			}
		}
		
		// AÇÕES DE RENAME DE ARQUIVOS/DIRETORIOS
		$count_rename = count($xml->{'package-actions'}->{'rename'});
		if($count_rename > 0)
		{
			// Verifica todas as instruções de copia de arquivos
			for($i = 0; $i < $count_rename; $i++)
			{
				$return['package-actions'][(int)$xml->{'package-actions'}->{'rename'}[$i]->attributes()->order]['rename']['from'] = replace_define_constant((string)$xml->{'package-actions'}->{'rename'}[$i]->attributes()->from);
				$return['package-actions'][(int)$xml->{'package-actions'}->{'rename'}[$i]->attributes()->order]['rename']['to'] = replace_define_constant((string)$xml->{'package-actions'}->{'rename'}[$i]->attributes()->to);
			}
		}
		
		// Organiza as ações do pacote com base na ordem (índice do array inferior)
		ksort($return['package-actions']);
		
		// Total de ações do pacote
		$return['package-total-exec'] = ($count_rmdir + $count_mkdir + $count_copy_replace + $count_sql + $count_unlink + $count_rename);
		
		// Calcula a porcentagem de cada instrução
		$return['package-average-percentage'] = ($return['package-total-exec'] > 0 ) ? ceil(100 / $return['package-total-exec']) : 0;
		
		// Verifica dependencia de pacotes
		$return['package-dependencies']['version'] = array();
		$count_dependencies = count($xml->{'package-dependencies'}->{'version'});
		if($count_dependencies > 0)
		{
			// Verifica todas as instruções de run sql
			for($i = 0; $i < $count_dependencies; $i++)
			{
				$return['package-dependencies']['version'][$i] = (string)$xml->{'package-dependencies'}->{'version'}[$i]->attributes()->value;
			}
		}
		
		// Apaga os diretórios temporários
		$zip->close();
		$zip_package->close();		
		$this->load->helper('file');
		delete_files($temp_dir, true);
		@rmdir($temp_dir);
		
		// Retorno ajustado
		return $return;
	}
	
	/**
	* _install_package_update()
	* Instala o pacote de atualização com base em um nome de arquivo já previamente verificado e 
	* processado. Caso existam erros durante a instalação, retorna array de mensagem de erros;
	* @param string file_name
	* @return mixed status/errors
	*/
	public function _install_package_update($file_name = '')
	{
		// Seta tempo total do script para infinito
		set_time_limit(0);
		
		// Porcentagem atual da instalação
		$actual_percentage = 0;
		
		// Inicializa objeto de manipulacao zip
		$zip = new ZipArchive();
		$zip->open($file_name);
		
		// Extrai arquivo para diretório temporário
		$temp_dir = 'application/temp/acme/' . uniqid();
		$zip->extractTo($temp_dir);
		
		// Abre o pacote interno
		$package_file = $temp_dir . '/package.zip';
		$zip_package = new ZipArchive();
		$zip_package->open($package_file);
		
		// Descompacta pacote interno
		$temp_dir_package = $temp_dir . '/package';
		$zip_package->extractTo($temp_dir_package);
		
		// Processa o pacote para rodar a instalação
		$package = $this->_process_package_update($file_name);
		
		// Variavel de retorno/erros
		$return = array();
		
		// Executa todas as instruções, uma a uma, conforme a ordem delas no array de ações
		foreach($package['package-actions'] as $instruction_number => $action) 
		{
			switch(strtolower(key($action)))
			{
				case 'mkdir':
					try {
						if(!is_dir($action['mkdir']))
							if(!mkdir($action['mkdir']))
								$return[$instruction_number] = lang('Não foi possível criar o diretório ') . $action['mkdir'] . '. ';
					} catch(Exception $e) {
						$return[$instruction_number] = lang('Não foi possível criar o diretório ') . $action['mkdir'] . '. ' . lang('Detalhes do erro: ') . $e->getMessage();
					}
				break;
				
				case 'rmdir':
					try {
						// Deleta o diretorio propriamente dito (com tudo dentro)
						if(!@delete_dir(eval_replace(htmlentities($action['rmdir']))))
							$return[$instruction_number] = lang('Não foi possível deletar o diretório ') . $action['rmdir'] . '. ';
					} catch(Exception $e) {
						$return[$instruction_number] = lang('Não foi possível deletar o diretório ') . $action['rmdir'] . '. ' . lang('Detalhes do erro: ') . $e->getMessage();
					}
				break;
				
				case 'unlink':
					try {
						if(file_exists($action['unlink']))
							if(!@unlink($action['unlink']))
								$return[$instruction_number] = lang('Não foi possível remover o arquivo ') . $action['unlink'] . '. ';
					} catch(Exception $e) {
						$return[$instruction_number] = lang('Não foi possível remover o arquivo ') . $action['unlink'] . '. ' . lang('Detalhes do erro: ') . $e->getMessage();
					}
				break;
				
				case 'rename':
					try {
						if(!@rename($action['rename']['from'], $action['rename']['to']))
							$return[$instruction_number] = lang('Não foi possível renomear o arquivo especificado ') . '(' . lang('de') . ' ' . $action['rename']['from'] . ' ' . lang(' para ') . $action['rename']['to'] . ').';
					} catch(Exception $e) {
						$return[$instruction_number] = lang('Não foi possível renomear o arquivo especificado ') . '(' . lang('de') . ' ' . $action['rename']['from'] . ' ' . lang(' para ') . $action['rename']['to'] . ').';
					}
				break;
				
				case 'run-sql-file':
					// CONECTA-SE MANUALMENTE NO BANCO DE DADOS PARA RODAR QUERY DE ARQUIVO
					$link = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_DATABASE, DB_PORT);
					$result = mysqli_multi_query($link, file_get_contents($temp_dir_package . '/' . $action['run-sql-file']['file']));
					
					// Varre todas as instruções armazenadas para acabar com o asincrono
					do {
						if($result = mysqli_store_result($link)){
							mysqli_free_result($result);
						}
					} while(mysqli_next_result($link));

					// Caso não existam erros nas instruções
					if(!mysqli_error($link))
						mysqli_close($link);
					else
						$return[$instruction_number] = lang('Erro na execução de query do arquivo') . ' ' . $action['run-sql-file']['file'] . ' ' . lang('contido no pacote. Detalhes do problema: ') . mysqli_error($link);
				break;
				
				case 'copy-replace-file':
					try {
						if(!@copy($temp_dir_package . '/' . $action['copy-replace-file']['from'], $action['copy-replace-file']['to']))
							$return[$instruction_number] = lang('Não foi possível copiar o arquivo para o local especificado ') . '(' . lang('de') . ' ' . $action['copy-replace-file']['from'] . ' ' . lang(' para ') . $action['copy-replace-file']['to'] . ').';
					} catch(Exception $e) {
						$return[$instruction_number] = lang('Não foi possível copiar o arquivo para o local especificado ') . '(' . lang('de') . ' ' . $action['copy-replace-file']['from'] . ' ' . lang(' para ') . $action['copy-replace-file']['to'] . ').';
					}
				break;
			}
			
			// Seta a porcentagem atual da instalação
			$actual_percentage += $package['package-average-percentage'];
			$actual_percentage = ($actual_percentage > 100) ? 100 : $actual_percentage;
			
			// Altera a porcentagem atual enviando conteúdo pro browser
			echo "<script type=\"text/javascript\">$('#percentage_install').css('width', '" . $actual_percentage . "%');$('#progress_value').html('" . $actual_percentage . "%');</script>\n";
			echo str_repeat(' ',1024*64);
			sleep(1);
			flush();
			ob_flush();
		}
		
		// Inicializa transação para inserção de pacote e dados
		$this->db->trans_start();
		
		// Marca o pacote como instalado no sistema
		$arr_ins['name'] = $package['package-name'];
		$arr_ins['version'] = $package['package-version'];
		$arr_ins['version_father'] = $package['package-version-father'];
		$arr_ins['path_file'] = $file_name;
		$arr_ins['description'] = $package['package-description'];
		$arr_ins['dtt_package_available'] = $package['package-dtt-available'];
		$arr_ins['dtt_package_installed'] = date('Y-m-d');
		$this->db->insert('acm_app_package_update', $arr_ins);
		$id_package = $this->db->insert_id();
		
		// Caso existam mensagens de erro, exibi-las
		if(count($return) > 0)
		{
			// Insere no banco de dados todas as mensagens de erro, uma a uma
			foreach($return as $order => $error)
				$this->db->insert('acm_app_package_update_error_message', array('id_app_package_update' => $id_package, 'message' => $error, 'order' => $order));
			
			// Exibe bloco de erros
			echo "<script type=\"text/javascript\">$('#box_errors_details').show();</script>\n";
			echo "<script type=\"text/javascript\">$('#errors_count').html('" . count($return) . "');</script>\n";
			echo "<script type=\"text/javascript\">$('#percentage_install').css('background-color', '#FFE875').css('border-left', '3px solid #FFA724');</script>\n";
			echo "<script type=\"text/javascript\">ajax_show_install_errors('" . $package['package-version'] . "');</script>\n";
			echo str_repeat(' ',1024*64);
			flush();
			ob_flush();
		}
		
		// Altera a versão atual do sistema alterando arquivo acme_version.php
		$version_file = file_get_contents('application/core/acme/engine_files/updater_template_acme_version.php');
		file_put_contents('application/core/acme/acme_version.php', str_replace('<TEMPLATE_VERSION>', $package['package-version'], $version_file));
		
		// Finaliza a instalação
		// Apaga os diretórios temporários
		$zip->close();
		$zip_package->close();		
		$this->load->helper('file');
		delete_files($temp_dir, true);
		rmdir($temp_dir);
		
		// Corrige retorno (caso array não tenha sido preenchido 
		// em nenhum lugar, então não ocorreram erros)
		if(count($return) <= 0)
		{
			unset($return);
			$return = true;
		}
		
		// Exibe mensagem de finalizado com sucess
		echo "<script type=\"text/javascript\">$('#msg_installing').html('" . lang('Feito! Veja os detalhes abaixo.') . "');</script>\n";
		echo "<script type=\"text/javascript\">$('#msg_install_success').show();</script>\n";
		echo "<script type=\"text/javascript\">$('#loading_layer_custom').remove();</script>\n";
		echo str_repeat(' ',1024*64);
		flush();
		ob_flush();
		
		// Inicializa transação para inserção de pacote e dados
		$this->db->trans_complete();
		
		// Retorno ajustado
		return $return;
	}
	
	
}
