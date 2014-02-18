<?php 
/**
*
* Classe Array_Table
*
* Monta uma tabela de dados através de um array de dados. Suporta adição de colunas
* antes ou depois do processamento do html.
* 
* @since		27/08/2012
* @location		acme.libraries.array_table
*
*/
class Array_Table {
	// Definição de Atributos
	public $CI = null;
	public $data = array();
	public $html = '';
	public $id = '';
	public $class = '';
	public $columns = array();
	public $columnsBefore = array();
	public $columnsAfter = array();
	public $indexColumnBefore = 0;
	public $indexColumnAfter = 0;
	public $items_per_page = 100;
	public $page_link = '';
	public $actual_page = 1;
	
	/**
	* __construct()
	* Construtor de classe.
    * Define o ID da tabela, classe e o array de dados, caso necessário.
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
	* Retorna uma instancia desta classe.
	* @return object array_table
	*/
	public function get_instance()
	{
		return new Array_Table($this->get_id(), $this->get_class(), $this->get_data());
	}
	
	/**
	* set_items_per_page()
	* Seta a quantidade de itens por página, para a tabela.
	* @param integer count
	* @return void
	*/
	public function set_items_per_page($count = null)
	{
		$this->items_per_page = (!is_null($count) && $count != '') ? $count : $this->items_per_page;
	}
	
	/**
	* get_items_per_page()
	* Retorna a quantidade de itens por pagina.
	* @return $this->items_per_page
	*/
	public function get_items_per_page()
	{
		return $this->items_per_page;
	}
	
	/**
	* set_page_link()
	* Seta o link da página da tabela atual, para o submit da paginação.
	* @param string link
	* @return void
	*/
	public function set_page_link($link = null)
	{
		$this->page_link = (!is_null($link)) ? $link : $this->page_link;
	}
	
	/**
	* get_page_link()
	* Retorna o link de submit e paginacao da pagina.
	* @return $this->page_link
	*/
	public function get_page_link()
	{
		return $this->page_link;
	}
	
	/**
	* set_actual_page()
	* Seta a pagina atual da paginacao.
	* @param integer actual_page
	* @return void
	*/
	public function set_actual_page($actual_page = null)
	{
		$this->actual_page = (!is_null($actual_page) && $actual_page != '') ? $actual_page : $this->actual_page;
	}
	
	/**
	* get_actual_page()
	* Retorna a pagina atual da paginação.
	* @return $this->page_link
	*/
	public function get_actual_page()
	{
		return $this->actual_page;
	}
	
	/**
	* set_data()
	* Seta o array de dados para o encaminhado.
	* @param array data
	* @return void
	*/
	public function set_data($data = array())
	{
		$this->data = (!is_null($data) && count($data) > 0 ) ? $data : $this->data;
	}
	
	/**
	* getData()
	* Retorna o array de dados da classe.
	* @return $this->data
	*/
	public function get_data()
	{
		return $this->data;
	}
	
	/**
	* set_columns()
	* Array definindo quais colunas serão visiveis.
	* @param array data
	* @return void
	*/
	public function set_columns($data = array())
	{
		$this->columns = (!is_null($data) && count($data) > 0 ) ? $data : $this->columns;
		
		// Passa valores internos do array para caixa-baixa
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
	* Retorna o array de dados da classe.
	* @return $this->columns
	*/
	public function get_columns()
	{
		return $this->columns;
	}
	
	/**
	* empty_columns()
	* Zera todas as colunas da tabela.
	* @param array data
	* @return void
	*/
	public function empty_columns($data = array())
	{
		$this->columns = array();
		$this->columnsBefore = array();
		$this->columnsAfter = array();
	}
	
	/**
	* set_id()
	* Seta o ID encaminhado para o aributo id da classe.
	* @param string id
	* @return void
	*/
	public function set_id($id = null)
	{
		$this->id = (!is_null($id)) ? $id : $this->id;
	}
	
	/**
	* get_id()
	* Retorna o ID do atributo id da classe.
	* @return $this->id
	*/
	public function get_id()
	{
		return $this->id;
	}
	
	/**
	* set_class()
	* Seta o class encaminhado para o aributo class da classe.
	* @param string class
	* @return void
	*/
	public function set_class($class = null)
	{
		$this->class = (!is_null($class)) ? $class : $this->class;
	}
	
	/**
	* get_class()
	* Retorna o Class do atributo class da classe.
	* @return $this->class
	*/
	public function get_class()
	{
		return $this->class;
	}
    
    /**
	* add_column()
	* Este método adiciona uma coluna à tabela. Caso algum número
	* de coluna do SQL esteja entre a tag [NÚMERO_COLUNA], então 
	* a tabela substitui o valor da coluna da linha corrente pela tag.
	* O segundo parâmetro verifica se a coluna deve ser posta no iní-
	* cio da tabela ou após o processamento do SQL.
	* @param string prConteudo
    * @param boolean prBefore
	* @return void
	*/
	public function add_column($prConteudo = null, $prBefore = true)
	{
		if(!is_null($prConteudo))
		{
			if($prBefore)
			{
				$this->columnsBefore[$this->indexColumnBefore] = $prConteudo;
				$this->indexColumnBefore++;
			} else {
				$this->columnsAfter[$this->indexColumnAfter] = $prConteudo;
				$this->indexColumnAfter++;
			}
		}
	}
    
	/**
	* process()
	* Este método processa o array de dados e monta a tabela conforme
	* os dados configurados anteriormente. Utiliza componente html generic table.
	* @return void
	*/
	public function process()
	{
		$this->html = $this->CI->template->load_html_component('generic_table', array('this' => $this));
	}
	
    /**
	* get_html()
	* Este método processa a tabela e retorna o 
	* HTML processado.
	* @return string HtmlTable
	*/
	public function get_html()
	{
		$this->process();
		return $this->html;
	}
    
    /**
	* render()
	* Processa a tabela e renderiza o html gerado.
	* @return void
	*/
	public function render()
	{
		$this->process();
		echo $this->html;
	}
}
