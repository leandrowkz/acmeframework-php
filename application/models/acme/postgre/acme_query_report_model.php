<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
*
* Classe Acme_Query_Report_Model
*
* Gerencia camada de dados do módulo de relatórios SQL genéricos do sistema.
* 
* @since		24/07/2013
* @location		acme.models.acme_query_report_model
*
*/
class Acme_Query_Report_Model extends Base_Module_Model {
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
