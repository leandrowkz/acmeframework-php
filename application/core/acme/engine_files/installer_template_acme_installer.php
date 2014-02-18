<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
*
* Acme_Installer
* 
* Módulo de instalação do ACME Engine e preparação para a construção da nova aplicação.
*
* @since		30/03/2013
* @location		acme.controllers.acme_installer
*
*/
class Acme_Installer extends Acme_Engine {
	// Definição de atributos
	
	/**
	* __construct()
	* Construtor de classe.
	* @return object
	*/
	public function __construct()
	{
		parent::__construct();
		
		// Defines específicos para visualização do template (scripts e imagens)
		define('URL_INCLUDE_ACME', URL_TEMPLATE . '/_acme/_includes');
		define('URL_CSS_ACME', URL_INCLUDE_ACME . '/css');
		define('URL_IMG_ACME', URL_INCLUDE_ACME . '/img');
		
		// Verifica se installer pode ser aberto
		if(!$this->_check_installer_permissions())
		{
			$this->template->load_page('_acme/acme_installer/error_opening', array('msg' => lang('O módulo Installer (instalador) não pode ser aberto. Verifique as possíveis causas:<br /><br />
			&bull;&nbsp;Diretório <strong>application/controllers</strong> (e seus subdiretórios) sem permissões de leitura e/ou escrita<br />
			&bull;&nbsp;Diretório <strong>application/core</strong> (e seus subdiretórios) sem permissões de leitura e/ou escrita<br />
			&bull;&nbsp;Diretório <strong>application/config</strong> (e seus subdiretórios) sem permissões de leitura e/ou escrita<br />
			&bull;&nbsp;Arquivo <strong>application/core/acme/engine_files/installer_create_database.sql</strong> faltando<br />
			&bull;&nbsp;Arquivo <strong>application/core/acme/engine_files/installer_dump_database.sql</strong> faltando<br />
			&bull;&nbsp;Arquivo <strong>application/core/acme/engine_files/installer_insert_master_user.sql</strong> faltando<br />
			&bull;&nbsp;Arquivo <strong>application/core/acme/engine_files/installer_template_acme_installer.php</strong> faltando<br />
			&bull;&nbsp;Arquivo <strong>application/core/acme/engine_files/installer_template_application_settings.php</strong> faltando<br />')), false, false);
		}
	}
	
	/**
	* index()
	* Método 'padrão' do controlador. Tela de instalação, ou passo 1.
	* @return void
	*/
	public function index()
	{
		redirect('acme_access');
	}
	
	/**
	* step_two()
	* Passo 2 da instalação do sistema. Testa novamente os requisitos do sistema antes de 
	* prosseguir.
	* @return void
	*/
	public function step_two()
	{
		redirect('acme_access');
	}
	
	/**
	* step_two_process()
	* Processa passo 2 da instalação do sistema. Testa novamente os requisitos do sistema antes de 
	* prosseguir. Caso a validação do formulário esteja ok, instala o sistema.
	* @return void
	*/
	public function step_two_process()
	{
		redirect('acme_access');
	}
	
	/**
	* summary()
	* Resumo da instalação.
	* @return void
	*/
	public function summary()
	{
		if($this->session->userdata('installed') === true)
		{
			$this->template->load_page('_acme/acme_installer/summary', array(), false, false);
		} else {
			redirect('acme_installer');
		}	
	}
}
