<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
*
* Classe <CLASS_NAME>_Model (Arquivo gerado com construtor de módulos)
* 
* Módule <CLASS_NAME>: <MODULE_DESCRIPTION>
*
* @since		<CREATION_DATE>
* @location		models.<CLASS_NAME>_model
*
*/
class <CLASS_NAME>_Model extends Base_Module_Model {
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
	
	/**
	* example()
	* Método de 'exemplo' da camada modelo. Quando um controlador invocar através da 
	* chamada $this-><CLASS_NAME>_Model->example(), este método será disparado.
	* @return void
	*/
	public function example()
	{
		// EXEMPLO DE COMO MANIPULAR QUERIES
		/*
		$sql = "SELECT * FROM table";
		$data = $this->db->query($sql);
		$data = $data->result_array();
		return (isset($data)) ? $data : array();
		*/
	}
}
