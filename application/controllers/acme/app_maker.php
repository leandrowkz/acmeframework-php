<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
*
* Acme_Maker
* 
* Módulo construtor de módulos internos.
*
* @since		15/10/2012
* @location		acme.controllers.acme_maker
*
*/
class Acme_Maker extends Acme_Engine {
	// Definição de atributos
	public $path_handle = null;
	public $path_module_files = 'application/temp/acme';
	
	/**
	* __construct()
	* Construtor de classe.
	* @return object
	*/
	public function __construct()
	{
		parent::__construct();
		
		// Valida acesso (Sessão)
		$this->access->validate_session();
		
		// Verifica se maker pode ser aberto
		if($this->_check_maker_permissions())
		{			
			// Verifica se diretório possui permissões de leitura e/ou escrita
			if($this->_check_path_permissions($this->path_module_files))
			{
				$this->path_handle = @opendir($this->path_module_files);
			} else {
				$this->error->show_exception_page(lang('Diretório <strong>' . $this->path_module_files . '</strong> sem permissões de leitura e/ou escrita. Verifique as permissões do diretório e tente o acesso novamente.'));
			}
		} else {
			$this->error->show_exception_page(lang('O módulo Maker (construtor de módulos) não pode ser aberto. Verifique as possíveis causas:<br /><br />
			&bull;&nbsp;Diretório <strong>application/controllers</strong> sem permissões de leitura e/ou escrita<br />
			&bull;&nbsp;Diretório <strong>application/models</strong> sem permissões de leitura e/ou escrita<br />
			&bull;&nbsp;Diretório <strong>application/views/' . TEMPLATE . '</strong> sem permissões de leitura e/ou escrita<br />
			&bull;&nbsp;Diretório <strong>application/core/acme/engine_files</strong> sem permissões de leitura e/ou escrita<br />
			&bull;&nbsp;Arquivo <strong>application/core/acme/engine_files/maker_template_controller.php</strong> faltando<br />
			&bull;&nbsp;Arquivo <strong>application/core/acme/engine_files/maker_template_model.php</strong> faltando<br />
			&bull;&nbsp;Arquivo <strong>application/core/acme/engine_files/maker_template_module_file.xml</strong> faltando<br />
			&bull;&nbsp;Arquivo <strong>application/core/acme/engine_files/maker_template_module_file.ini</strong> faltando<br />
			&bull;&nbsp;Arquivo <strong>application/core/acme/engine_files/maker_template_module_file_custom_action.ini</strong> faltando<br />
			&bull;&nbsp;Arquivo <strong>application/core/acme/engine_files/maker_template_module_file_custom_menu.ini</strong> faltando<br />
			&bull;&nbsp;Arquivo <strong>application/core/acme/engine_files/maker_template_module_file_custom_permission.ini</strong> faltando<br />'));
		}
	}
	
	/**
	* index()
	* Método 'padrão' do controlador. Listagem de arquivos não finalizados.
	* @return void
	*/
	public function index()
	{
		$this->access->validate_permission('acme_maker', 'ENTER');
		
		// Inicializa variaveis de arquivo e contagem
		$i = 0;
		$files = array();
		
		// Monta um array de arquivos do diretório
		while(false !== ($file = readdir($this->path_handle))) 
		{
			if($file != '.' && $file != '..' && $file != '.svn' && $file != '.htaccess')
			{
				$files[$i]['name'] = $file;
				$files[$i]['date_creation'] = date("d/m/Y H:i:s", filectime($this->path_module_files . '/' . $file));
				$i++;
			}
		}
		
		// Variaveis para view
		$args['files'] = $files;
		
		// Carrega view
		$this->template->load_page('_acme/acme_maker/index', $args);
	}
	
	/**
	* delete_module()
	* Deleção de arquivo de módulo. 
	* @param string file_name
	* @return void
	*/
	public function delete_module($file_name = '')
	{
		$this->access->validate_permission('acme_maker', 'CREATE_MODULE');
		
		if($file_name != '')
		{
			$this->_delete_module_file($this->path_module_files . '/' . $file_name);
		} else {
			redirect('acme_maker');
		}	
	}
	
	/**
	* new_module()
	* Tela de criação de novo módulo. Exibe textarea onde serão inseridos os parâmetros do módulo a
	* ser criado. Caso informado file_name, abre a tela com conteúdo do arquivo informado.
	* @param string file_name (opcional)
	* @return void
	*/
	public function new_module($file_name = '')
	{
		$this->access->validate_permission('acme_maker', 'CREATE_MODULE');
		
		// Inicializa variável de conteúdo
		$content = '';
		
		// Verifica conteudo do arquivo
		if($file_name != '')
		{
			if($this->_check_file_permissions($this->path_module_files . '/' . $file_name))
			{
				$content = file_get_contents($this->path_module_files . '/' . $file_name);
			} else {
				$this->error->show_exception_page(lang('Arquivo') . ' <strong>' . $this->path_module_files . '/' . $file_name . '</strong> ' . lang('não existe ou não possui permissões de leitura e/ou escrita. Verifique as permissões do arquivo e tente novamente.') . '<br /><br /><a href="' . URL_ROOT . '/acme_maker/new_module/">' . lang('Clique aqui para voltar') .'</a>');
			}
		}
		
		// Variaveis para view
		$args['content'] = $content;
		$args['file_name'] = $file_name;
		
		// Carrega view (conforme o método de criação de módulos atualmente setado em engine)
		$this->template->load_page('_acme/acme_maker/new_module_' . $this->file_method_process, $args);
	}
	
	/**
	* new_module_process()
	* Processa tela de criação de novo módulo. Conforme a opção selecionada (salvar ou salvar e analisar)
	* faz o salvamento e análise do arquivo.
	* @return void
	*/
	public function new_module_process()
	{
		// Arquivo já existe, deve sobrescrever conteudo
		if($this->input->post('ini_file') != '' && $this->input->post('file_name') != '')
		{
			$file = $this->input->post('file_name');
			if(!$this->_update_module_file($this->input->post('ini_file'), $this->path_module_files . '/' . $file))
				$this->error->show_exception_page(lang('Arquivo não pôde ser criado. Provavelmente o diretório não possui permissões de leitura e/ou escrita habilitadas. Verifique estas permissões e tente novamente.'));
		} 
		
		// Arquivo nao existe, cria-lo
		else if ($this->input->post('ini_file') != '' && $this->input->post('file_name') == '')
		{
			// Cria o arquivo físico com conteúdo do textarea
			if(($file = $this->_create_module_file($this->input->post('ini_file'), $this->path_module_files)) == false)
				$this->error->show_exception_page(lang('Arquivo não pôde ser criado. Provavelmente o diretório não possui permissões de leitura e/ou escrita habilitadas. Verifique estas permissões e tente novamente.'));
		}
		
		// Verifica ação do botão
		if(strtolower($this->input->post('btn_action')) != 'salvar')
		{
			// Avalia arquivo encaminhado, pré-criação do módulo
			redirect('acme_maker/analyze_module/' . $file);
		}
		
		// Caso ini file ou botão salvar
		redirect('acme_maker');
	}
	
	/**
	* analyze_module()
	* Analisa arquivo de nome encaminhado e faz um 'review' do que vai ser criado. Exibe tela de
	* revisão; um passo antes da criação do módulo.
	* @param string file_name
	* @return void
	*/
	public function analyze_module($file_name = '')
	{
		$this->access->validate_permission('acme_maker', 'CREATE_MODULE');
		
		if($file_name != '')
		{
			if($this->_check_file_permissions($this->path_module_files . '/' . $file_name))
			{
				// Verifica se arquivo possui erros (o retorno ou é um true ou 
				// um array associativo de erros, por isso o teste com === )
				$args['file_name'] = $file_name;
				$args['validation'] = $this->_analyze_module_file($this->path_module_files . '/' . $file_name);
				$args['file_data'] = $this->_process_module_file($this->path_module_files . '/' . $file_name);
				
				// Calcula action do formulário
				if($args['validation'] === true)
				{
					$args['action_form'] = URL_ROOT . '/acme_maker/create_module/' . $file_name;
					$args['content'] = @file_get_contents($file_name);
				} else {
					$args['action_form'] = URL_ROOT . '/acme_maker/new_module/' . $file_name;
					$args['content'] = '';
				}
				
				// Carrega view
				$this->template->load_page('_acme/acme_maker/analyze_module', $args);
			} else {
				$this->error->show_exception_page(lang('Arquivo') . ' <strong>' . $this->path_module_files . '/' . $file_name . '</strong> ' . lang('não existe ou não possui permissões de leitura e/ou escrita. Verifique as permissões do arquivo e tente novamente.') . '<br /><br /><a href="' . URL_ROOT . '/acme_maker/new_module/">' . lang('Clique aqui para voltar') .'</a>');
			}
		} else {
			redirect('acme_maker');
		}
	}
	
	/**
	* create_module()
	* Cria o módulo, finalmente, com base em um nome de arquivo encaminhado. O sistema verifica
	* se o arquivo é válido mais uma vez, por segurança, e faz os devidos inserts no banco de dados
	* com base nas informações contidas no arquivo.
	* @param string file_name
	* @return void
	*/
	public function create_module($file_name = '')
	{
		$this->access->validate_permission('acme_maker', 'CREATE_MODULE');
		
		if($file_name != '')
		{
			// Arquivo ok, criá-lo
			if($this->_analyze_module_file($this->path_module_files . '/' . $file_name) === true)
			{
				// Coleta dados do novo módulo, para informar na tela de criado com sucesso
				$args['file_data'] = $this->_process_module_file($this->path_module_files . '/' . $file_name);
				
				// Cria o módulo
				if($this->_create_module($this->path_module_files . '/' . $file_name) === true)
				{
					// Destrói arquivo
					$this->_delete_module_file($this->path_module_files . '/' . $file_name);
				} else {
					// Erro na geração
					$this->error->show_exception_page('Erro ao criar módulo');
				}
				
				// Coleta dados do módulo
				$query = $this->db->get_where('acm_module', array('controller' => get_Value($args['file_data'], 'controller')));
				$data = $query->row();
				$args['id_module'] = $data->id_module;
				
				// Carrega página de aviso de sucesso!
				$this->template->load_page('_acme/acme_maker/create_module', $args);
			} else {
				redirect('acme_maker');
			}
		} else {
			redirect('acme_maker');
		}	
	}
	
	/**
	* ajax_get_skeleton_module_file()
	* Retorna o conteúdo do arquivo template de esqueleto de estrutura de módulo. Segundo parametro
	* diz qual tipo de arquivo deverá ser copiado
	* @return void
	*/
	public function ajax_get_skeleton_module_file($method = '')
	{
		$this->access->validate_permission('acme_maker', 'CREATE_MODULE');
		echo $this->_get_skeleton_module_file($method);
	}
	
	/**
	* ajax_get_skeleton_custom_section()
	* Retorna o conteúdo de uma seção custom para arquivo de estrutura de módulo.
	* @param string section
	* @return void
	*/
	public function ajax_get_skeleton_custom_section($section = '')
	{
		$this->access->validate_permission('acme_maker', 'CREATE_MODULE');
		echo $this->_get_skeleton_custom_section($section);
	}
}
