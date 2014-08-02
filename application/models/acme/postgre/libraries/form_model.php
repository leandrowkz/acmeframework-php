<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* --------------------------------------------------------------------------------------------------
*
* Model Form_Model
*
* Camada model para a biblioteca Form.
* 
* @since 	24/10/2012
*
* --------------------------------------------------------------------------------------------------
*/
class Form_Model extends CI_Model {
	
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
	* get_field_meta_data()
	* Retorna meta-dados de um campo de nome e tabela encaminhados.
	* @param int id_form
	* @param string table
	* @return array fields
	*/
	public function get_field_meta_data($table = '', $column_name = '')
	{
		$sql = "SELECT * 
				  FROM information_schema.columns c

			 LEFT JOIN (SELECT ccu.column_name, 
							   ccu.table_name AS referenced_table_name, 
							   tc.constraint_type
						  FROM information_schema.table_constraints        tc
					 LEFT JOIN information_schema.constraint_column_usage ccu ON (ccu.constraint_name = tc.constraint_name)
					     WHERE tc.table_name   = '$table' 
						   AND tc.constraint_type = 'FOREIGN KEY'
			 ) fk ON (fk.column_name = c.column_name)
			 
			 LEFT JOIN (SELECT CASE WHEN tc.constraint_type = 'PRIMARY KEY' THEN 'PRI' ELSE '' END AS column_key,
			 				   ccu.column_name
			 	 		  FROM information_schema.table_constraints         tc
					 LEFT JOIN information_schema.constraint_column_usage  ccu ON (ccu.constraint_name = tc.constraint_name)
					     WHERE tc.table_name   = '$table'
						   AND tc.constraint_type = 'PRIMARY KEY'
			 ) pk ON (pk.column_name = c.column_name)

			 	 WHERE c.table_name  = '$table'
				   AND c.column_name = '$column_name'";
		
		return $this->db->query($sql)->row_array(0);
	}
}
