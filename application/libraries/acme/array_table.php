<?php
/**
* --------------------------------------------------------------------------------------------------
*
* Library Array_Table
*
* Gathers methods related with HTML tables. 
*
* The objective of this library is build HTML tables from arrays. 
*
* This library operates using singleton. One instance can be got by the call 
* $this->array_table->get_instance();
* 
* @since 	01/10/2012
*
* --------------------------------------------------------------------------------------------------
*/
class Array_Table {
	
	public $CI = null;
	public $data = array();
	public $html = '';
	public $id = '';
	public $class = '';
	public $columns = array();
	public $columns_before = array();
	public $columns_after = array();
	
	/**
	* __construct()
	* Class constructor.
    * Defines HTML id, class and array data of the current object.
	* @param string id
	* @param string class
	* @param array data
	* @return object
	*/
	public function __construct($id = null, $class= null, $data = array())
	{
        $this->data = (!is_null($data) && count($data) > 0) ? $data : $this->data;
		$this->id  = (!is_null($id)) ? $id : $this->id;
		$this->class = (!is_null($class)) ? $class : $this->class;
		$this->CI =& get_instance();
	}
	
	/**
	* get_instance()
	* Returns an instance of this class.
	* @return Array_Table object
	*/
	public function get_instance()
	{
		return new Array_Table($this->get_id(), $this->get_class(), $this->get_data());
	}
	
	/**
	* set_data()
	* Sets the array data of table.
	* @param array data
	* @return void
	*/
	public function set_data($data = array())
	{
		$this->data = (!is_null($data) && count($data) > 0 ) ? $data : $this->data;
	}
	
	/**
	* get_data()
	* Gets the array data of table.
	* @return $this->data
	*/
	public function get_data()
	{
		return $this->data;
	}
	
	/**
	* set_columns()
	* Sets columns of table - columns will be show.
	* @param array columns
	* @return void
	*/
	public function set_columns($columns = array())
	{
		$this->columns = (!is_null($columns) && count($columns) > 0 ) ? $columns : $this->columns;
		
		// Puts all values to lowercase
		$count_columns = count($this->columns);

		if($count_columns > 0)
		{
			for($i = 0; $i < $count_columns; $i++)
			{
				$aux[] = strtolower($this->columns[$i]);
			}
			$this->columns = $aux;
		}
	}
	
	/**
	* get_columns()
	* Returns all table columns.
	* @return $this->columns
	*/
	public function get_columns()
	{
		return $this->columns;
	}
	
	/**
	* empty_columns()
	* Clears all table columns.
	* @return void
	*/
	public function empty_columns()
	{
		$this->columns = array();
		$this->columns_before = array();
		$this->columns_after = array();
	}
	
	/**
	* set_id()
	* Sets the HTML id attribute of table.
	* @param string id
	* @return void
	*/
	public function set_id($id = null)
	{
		$this->id = (!is_null($id)) ? $id : $this->id;
	}
	
	/**
	* get_id()
	* Gets the HTML id attribute of table.
	* @return $this->id
	*/
	public function get_id()
	{
		return $this->id;
	}
	
	/**
	* set_class()
	* Sets the HTML class attribute of table.
	* @param string class
	* @return void
	*/
	public function set_class($class = null)
	{
		$this->class = (!is_null($class)) ? $class : $this->class;
	}
	
	/**
	* get_class()
	* Gets the HTML class attribute of table.
	* @return $this->class
	*/
	public function get_class()
	{
		return $this->class;
	}
    
    /**
	* add_column()
	* Adds a column value for each table row before or after selected columns.
	* @param string content
    * @param boolean before
	* @return void
	*/
	public function add_column($content = null, $before = true)
	{
		if(!is_null($content))
		{
			if($before)
				$this->columns_before[] = $content;
			else
				$this->columns_after[] = $content;
		}
	}
    
	/**
	* process()
	* Processes table data. Call the HTML component generic table, which is really responsible
	* to process this table.
	* @return void
	*/
	public function process()
	{
		$this->html = $this->CI->template->load_html_component('generic_table', array('array_table' => $this));
	}
	
    /**
	* get_html()
	* Gets HTML table from current table.
	* @return string html
	*/
	public function get_html()
	{
		$this->process();
		return $this->html;
	}
    
    /**
	* render()
	* Renders HTML table from current table.
	* @return void
	*/
	public function render()
	{
		$this->process();
		echo $this->html;
	}
}
