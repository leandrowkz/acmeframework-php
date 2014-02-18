<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
*
* Classe Acme_Config_Model
*
* Gerencia camada de dados do módulo configurações e variáveis do sistema.
* 
* @since		28/06/2013
* @location		acme.models.acme_config_model
*
*/
class Acme_Config_Model extends Base_Module_Model {
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
