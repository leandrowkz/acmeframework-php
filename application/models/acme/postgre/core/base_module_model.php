<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
*
* Classe Base_Module_Model
*
* Camada modelo do módulo padrão do sistema.
* 
* @since		04/10/2012
* @location		acme.models.base_module_model
*
*/
class Base_Module_Model extends CI_Model {
	// Definição de Atributos
	public $table = '';
	var $primary_key = '';
	var $sql_list = '';
	
	/**
	* __construct()
	* Construtor de classe. Chama o construtor pai, que abre uma conexão com
	* o banco de dados, automaticamente.
	* @return object
	*/
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	
	/**
	* set_sql_list()
	* Seta o sql de listagem do modulo com base no parametro encaminhado.
	* @param string sql
	* @return void
	*/
	public function set_sql_list($sql = '')
	{
		$this->sql_list = $sql;
	}
	
	/**
	* set_table()
	* Seta a tabela do modulo com base na informada.
	* @param string table
	* @return void
	*/
	public function set_table($table = '')
	{
		$this->table = $table;
	}
	
	/**
	* set_primary_key()
	* Seta a chave primaria com base na tabela setada.
	* @return void
	*/
	public function set_primary_key()
	{
		$this->primary_key = $this->get_primary_key();
	}
	
	/**
	* get_primary_key()
	* Retorna o nome da chave primaria da tabela do modulo. Espera-se que a tabela do modulo possua 
	* uma chave primaria de um unico campo, apenas.
	* @return string primary_key
	*/
	public function get_primary_key()
	{
		$this->table = 'acm_log';
		if($this->table == '')
			return '';
		
		// Retorna o nome da coluna primária conforme o tipo de banco
		switch(strtolower($this->db->dbdriver))
		{
			// MySQL and Postgre
			case 'mysql':
			case 'postgre':
				// Coleta todas as colunas da tabela informada
				$fields = $this->db->field_data($this->table);
				
				// Varre todos os campos a procura de um campo PK
				foreach($fields as $field) {
					if(isset($field->primary_key))
						if($field->primary_key == 1)
							return $field->name;
				}
			break;
			
			// Oracle
			case 'oci8':
				$sql = "SELECT cols.column_name
						  FROM all_constraints  cons
					INNER JOIN all_cons_columns cols ON (cons.constraint_name = cols.constraint_name AND cons.owner = cols.owner)
						 WHERE (cols.table_name = '" . strtoupper($this->table) . "' OR cols.table_name = '" . strtolower($this->table) . "')
						   AND cons.constraint_type = 'P'";
				// DEBUG
				// echo $sql;
				$data = $this->db->query($sql);
				$data = $data->result_array();
				return (isset($data[0])) ? get_value($data[0], 'column_name') : '';
			break;
		}
		
		return '';
	}
	
	/**
	* select()
	* Retorna o conjunto de dados da tabela do modulo. Opcional, recebe o valor do primary key 
	* como parametro.
	* @param integer primary_key_value
	* @return array data
	*/
	public function select($primary_key_value = 0)
	{
		$sql  = 'SELECT * FROM ' . $this->table;
		
		// Chave primaria
		$sql .= (is_integer_($primary_key_value) && $primary_key_value != 0) ? " WHERE " . $this->primary_key . " = '" . $primary_key_value . "'" : '';
		
		$data = $this->db->query($sql);
		$data = $data->result_array();
		return (isset($data)) ? $data : array();
	}
	
	/**
	* insert()
	* Insere registro na tabela do modulo.
	* @param array data
	* @return mixed result
	*/
	public function insert($data = array())
	{
		// Ajusta array dados
		foreach($data as $column => $value)
		{
			if($value == '')
			{
				$value = 'NULL';
				$escape = false;
			} else {
				// Verifica se valor é date e o converte corretamente
				if(is_date_format($value))
				{ 
					$arrdate = explode('/', $value);
					$value = $arrdate[2] . '-' . $arrdate[1] . '-' . $arrdate[0];
				}
				$escape = true;
			}
			$this->db->set($column, $value, $escape);
		}
		$result = $this->db->insert($this->table);
		return $result;
	}
	
	/**
	* update()
	* Altera registro(s) na tabela do modulo.
	* @param array data
	* @param mixed where (pode ser array('id' => $id)... ou string "id = 1")
	* @return mixed result
	*/
	public function update($data = array(), $where = array())
	{
		// Ajusta array dados
		foreach($data as $column => $value)
		{
			if($value == '')
			{
				$value = 'NULL';
				$escape = false;
			} else {
				// Verifica se valor é date e o converte corretamente
				if(is_date_format($value))
				{ 
					$arrdate = explode('/', $value);
					$value = $arrdate[2] . '-' . $arrdate[1] . '-' . $arrdate[0];
				}
				$escape = true;
			}
			$this->db->set($column, $value, $escape);
		}
		$this->db->where($where);
		$result = $this->db->update($this->table);
		return $result;
	}
	
	/**
	* delete()
	* Deleta registros da tabela do modulo.
	* @param mixed where (pode ser array('id' => $id)... ou string "id = 1")
	* @return mixed result
	*/
	public function delete($where = array())
	{
		$result = $this->db->delete($this->table, $where);
		return $result;
	}
	
	/**
	* get_module_data()
	* Retorna o conjunto de dados do módulo que está sendo carregado. Popula as variáveis deste model
	* com base nos valores cadastrados para o módulo (table e sql).
	* @param string controller
	* @return array data
	*/
	public function get_module_data($controller = '')
	{
		$sql = "SELECT * FROM acm_module WHERE controller = '$controller'";
		$data = $this->db->query($sql);
		$data = $data->result_array();
		return (isset($data[0])) ? $data[0] : array();
	}
	
	/**
	* get_resultset_module()
	* Retorna o resultset do sql do módulo.
	* @param array filters
	* @return array data
	*/
	public function get_resultset_module($filters = array())
	{
		// Prepara o $this->sql_list, adicionando os filtros a clausula where
		$this->prepare_sql_from_filter($filters);
		
		// Executa a consulta
		$data = $this->db->query($this->sql_list);
		$data = $data->result_array();
		
		// Retorno
		return (isset($data)) ? $data : array();
	}
	
	/**
	* get_filters()
	* Retorna listagem de inputs de filtros do módulo.
	* @return array filters
	*/
	public function get_filters($id_module = 0)
	{
		$sql = "SELECT ff.* 
				  FROM acm_module_form_field ff
			INNER JOIN acm_module_form        f ON (f.id_module_form = ff.id_module_form)
				 WHERE f.operation = 'filter' 
				   AND f.id_module = $id_module 
				   AND ff.dtt_inative IS NULL 
				   AND f.dtt_inative IS NULL
			  ORDER BY order_";
		$data = $this->db->query($sql);
		$data = $data->result_array();
		return (isset($data)) ? $data : array();
	}
	
	/**
	* get_menus()
	* Retorna listagem de menus do módulo.
	* @return array menus
	*/
	public function get_menus($id_module = 0)
	{
		$sql = "SELECT * FROM acm_module_menu WHERE id_module = $id_module AND dtt_inative IS NULL ORDER BY order_";
		$data = $this->db->query($sql);
		$data = $data->result_array();
		return (isset($data)) ? $data : array();
	}
	
	/**
	* get_actions()
	* Retorna listagem de actions de registros do módulo.
	* @return array actions
	*/
	public function get_actions($id_module = 0)
	{
		$sql = "SELECT * FROM acm_module_action WHERE id_module = $id_module AND dtt_inative IS NULL ORDER BY order_";
		$data = $this->db->query($sql);
		$data = $data->result_array();
		return (isset($data)) ? $data : array();
	}
	
	/**
	* prepare_sql_from_filter()
	* Este método prepara o sql do módulo com base nos filtros que possivelmente foram encaminhados 
	* via POST.
	* @param array filters
	* @return void
	*/
	public function prepare_sql_from_filter($filters = array())
	{
		if(!is_null($this->sql_list) && $this->sql_list != '' && count($filters) > 0)
		{
			// Inicializa controle se existe where em $this->sql
			$boolWhere = false;
			
			// Coleta SQL do módulo
			$sql = trim($this->sql_list, ';');
			
			// Verifica se existe 'WHERE'
			if(preg_match('/where/i', $sql , $where))
			{
				$arrSQL = explode($where[0], $sql);
				$arrSQL[0] .= ' WHERE 1=1 ';
				$boolWhere = true;
			} 
			// Verifica Group BY
			elseif(preg_match('/group by/i', $sql , $group))
			{
				$arrSQL = explode($group[0], $sql);
				$arrSQL[0] .= ' WHERE 1=1 ';
				$arrSQL[1]  = ' GROUP BY ' . $arrSQL[1];
			} 
			// Verifica Order BY
			elseif(preg_match('/order by/i', $sql , $order))
			{
				$arrSQL = explode($order[0], $sql);
				$arrSQL[0] .= ' WHERE 1=1 ';
				$arrSQL[1]  = ' ORDER BY ' . $arrSQL[1];
			}
			// Não veio nada, nada do where para lá
			else {
				$arrSQL[0] = $sql . ' WHERE 1=1 ';
				$arrSQL[1] = '';
			}
			
			// Varre campos adicionando clausulas ao where
			// print_r($filters);
			foreach($filters as $table => $column_value)
			{
				// Resolve o problema da coluna poder ser um array de colunas ou a coluna direta
				// isso acontece quando no name do campo não existe a informação da tabela e seu
				// nome vem direto
				if(is_array($column_value))
				{
					foreach($column_value as $column => $value)
					{
						// Verifica se tabela possui alias no sql
						// OBSERVAÇÃO: Encontrado problemas na montagem automática de where de filtros
						// quando a tabelas do sql de tem alias diferente do nome da tabela
						/*
						if(preg_match('/' . $table . '(\s)?(as)?(\s)?[a-zA-Z0-9\.\\_`\'"]+/i', $sql , $matches)) { print_r($matches); }
						*/
						$arrSQL[0] .= $this->prepare_field_filter_statement($table . '.' .$column, $value);
					}
				} else {
					$arrSQL[0] .= $this->prepare_field_filter_statement($table, $column_value);
				}
			}
				
			// Somente clausulas where tem mais campos posteriores
			$arrSQL[0] .= ($boolWhere) ? ' AND ' . $arrSQL[1] : $arrSQL[1];

			// echo($arrSQL[0]);
			$this->sql_list = $arrSQL[0];
		}
	}
	
	/**
	* prepare_field_filter_statement()
	* Prepara o campo conforme seu valor e retorna uma string sql.
	* @param string column
	* @param mixed value
	* @return void
	*/
	public function prepare_field_filter_statement($column = '', $value = '')
	{
		// Carrega controlador CI para uso de funcoes internas
		$CI =& get_instance();
		$CI->load->library('acme/validation');
		
		// Só acrescenta a linha caso o valor do campo seja diferente de vazio
		if($value != '')
		{
			if($CI->validation->is_integer_($value) || $CI->validation->is_float_($value))
			{
				return " AND $column = $value";
			}
		
			elseif($CI->validation->is_alfa($value))
			{
				return " AND $column LIKE '%" . $this->db->escape_like_str($value) . "%'";
			}
		
			elseif($CI->validation->is_currency($value))
			{
				return " AND $column = '" . $value . "'";
			}
			
			elseif(isset($value)) 
			{
				return " AND $column LIKE '%" . $this->db->escape_like_str($value) . "%'";
			}
		}
	}
	
	/**
	* get_form()
	* Retorna dados de um formulario de modulo, com base na operacao encmainhada.
	* @param integer id_module
	* @param string operation
	* @return array form
	*/
	public function get_form($id_module = 0, $operation = '')
	{
		$sql = "SELECT m.table,
					   f.* 
				  FROM acm_module_form f
			INNER JOIN acm_module             m ON (m.id_module = f.id_module)
				 WHERE f.id_module = $id_module 
				   AND f.operation = '$operation'	
				   AND f.dtt_inative IS NULL";
		$data = $this->db->query($sql);
		$data = $data->result_array();
		return (isset($data[0])) ? $data[0] : array();
	}
	
	/**
	* get_form_fields()
	* Retorna campos de formulario de um modulo.
	* @param integer id_form
	* @return array fields
	*/
	public function get_form_fields($id_form = 0, $operation = '')
	{
		// Ajusta id_form
		$id_form = ($id_form == '') ? 0 : $id_form;
		
		// Consulta campos do form
		$sql = "SELECT m.table,
					   ff.* 
				  FROM acm_module_form_field ff 
			INNER JOIN acm_module_form        f ON (f.id_module_form = ff.id_module_form)
			INNER JOIN acm_module             m ON (m.id_module = f.id_module)
				 WHERE ff.id_module_form = $id_form
				   AND ff.dtt_inative IS NULL
			  ORDER BY ff.order_";
		$data = $this->db->query($sql);
		$data = $data->result_array();
		return (isset($data)) ? $data : array();
	}
}
