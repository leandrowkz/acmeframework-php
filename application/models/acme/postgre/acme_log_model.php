<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
*
* Classe Acme_Log_Model
*
* Gerencia camada de dados do módulo de logs do sistema.
* 
* @since		03/11/2012
* @location		acme.models.acme_log_model
*
*/
class Acme_Log_Model extends Base_Module_Model {
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
