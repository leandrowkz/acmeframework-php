<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
*
* Classe Acme_Log_Error_Model
* 
* Gerencia camada de dados do módulo de logs de erros do sistema.
*
* @since		05/04/2013
* @location		acme.models.acme_log_error_model
*
*/
class Acme_Log_Error_Model extends Base_Module_Model {
	// Definição de Atributos
	
	/**
	* __construct()
	* Construtor de classe. Chama o construtor pai, que abre uma conexão com
	* o banco de dados, automaticamente.
	* @return object
	*/
	public function __construct()
	{
		parent::__construct();
	}
}
