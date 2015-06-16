<?php
/**
 * --------------------------------------------------------------------------------------------------
 * Library Array_Table
 *
 * Gathers methods related with HTML tables.
 *
 * The goal of this library is build HTML tables from arrays.
 *
 * This library operates using singleton. One instance can be got by the call
 * $this->array_table->get_instance();
 *
 * @since 	01/10/2012
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
	 * Class constructor.
	 * Defines HTML id, class and array data of the current object.
	 *
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
	 * Returns an instance of this class.
	 *
	 * @return Array_Table object
	 */
	public function get_instance()
	{
		return new Array_Table($this->get_id(), $this->get_class(), $this->get_data());
	}

	/**
	 * Sets the array data of table.
	 *
	 * @param array data
	 * @return void
	 */
	public function set_data($data = array())
	{
		$this->data = (!is_null($data) && count($data) > 0 ) ? $data : $this->data;
	}

	/**
	 * Gets the array data of table.
	 *
	 * @return $this->data
	 */
	public function get_data()
	{
		return $this->data;
	}

	/**
	 * Sets columns of table - columns thath will be show.
	 *
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
	 * Returns all table columns.
	 *
	 * @return $this->columns
	 */
	public function get_columns()
	{
		return $this->columns;
	}

	/**
	 * Clears all table columns.
	 *
	 * @return void
	 */
	public function empty_columns()
	{
		$this->columns = array();
		$this->columns_before = array();
		$this->columns_after = array();
	}

	/**
	 * Sets the HTML id attribute of table.
	 *
	 * @param string id
	 * @return void
	 */
	public function set_id($id = null)
	{
		$this->id = (!is_null($id)) ? $id : $this->id;
	}

	/**
	 * Gets the HTML id attribute of table.
	 *
	 * @return $this->id
	 */
	public function get_id()
	{
		return $this->id;
	}

	/**
	 * Sets the HTML class attribute of table.
	 *
	 * @param string class
	 * @return void
	 */
	public function set_class($class = null)
	{
		$this->class = (!is_null($class)) ? $class : $this->class;
	}

	/**
	 * Gets the HTML class attribute of table.
	 *
	 * @return $this->class
	 */
	public function get_class()
	{
		return $this->class;
	}

    /**
     * Adds a column value for each table row before or after selected columns.
     *
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
	 * Processes table data. Call the HTML component generic table, which is
	 * really responsible to process this table.
	 *
	 * @return void
	 */
	public function process()
	{
		$this->html = $this->CI->template->load_html_component('generic-table', array('array_table' => $this));
	}

    /**
     * Gets HTML table from current table.
     *
     * @return string html
     */
	public function get_html()
	{
		$this->process();
		return $this->html;
	}

    /**
     * Renders HTML table from current table.
     *
     * @return void
     */
	public function render()
	{
		$this->process();
		echo $this->html;
	}
}
