<?php
/**
* --------------------------------------------------------------------------------------------------
*
* Library Template
*
* Biblioteca de funções relacionadas ao uso do template da aplicação.
* 
* @since 	10/09/2012
*
* --------------------------------------------------------------------------------------------------
*/
class Template {
	
	public $CI = null;
	
	/**
	* __construct()
	* Construtor de classe.
	* @return object
	*/
	public function __construct()
	{
		$this->CI =& get_instance();
	}
	
	/**
	* load_page()
	* Carrega página de view.
	* @param string page
	* @param array vars
	* @param boolean return_html
	* @param boolean load_master_page
	* @return mixed
	*/
	public function load_page($page = '', $arr_vars = array(), $return_html = false, $load_master_page = true)
	{
		if($load_master_page)
		{
			$html = $this->CI->load->view(TEMPLATE . '/' . $page, $arr_vars, true);
			$html = $this->CI->load->view(TEMPLATE . '/' . 'master', array('html' => $html), $return_html);
			if($return_html){ return $html; }
		} else {
			$html = $this->CI->load->view(TEMPLATE . '/' . $page, $arr_vars, $return_html);
			if($return_html){ return $html; }
		}
	}

	/**
	* load_html_component()
	* Carrega componente html de nome encaminhado. Espera-se que exista um diretorio, arquivo e 
	* função de mesmo nome do que encaminhado. O segundo parametro é um array de parametros que 
	* serão encaminhados à função.
	* @param string component
	* @param array params
	* @return string html_menu
	*/
	public function load_html_component($component = '', $params = array())
	{
		include_once('application/views/' . PATH_HTML_COMPONENTS . '/' . $component . '/' . $component . '.php');
		
		// Realiza chamada da função
		return call_user_func_array($component, $params);	
	}
	
	/**
	* load_js_file()
	* Carrega um arquivo js, retornando tag script. O nome do arquivo encaminhado como parametro
	* não deve conter a extensão do arquivo.
	* @param string file
	* @return string html
	*/
	public function load_js_file($file = '')
	{
		return '<script src="' . URL_JS . '/' . $file . '"></script>' . "\n";
	}
	
	/**
	* load_css_file()
	* Carrega um arquivo css, retornando tag <link...>. O nome do arquivo encaminhado como parametro
	* pode não conter a extensão do arquivo.
	* @param string file
	* @return string html
	*/
	public function load_css_file($file = '')
	{
		return '<link type="text/css" rel="stylesheet" href="' . URL_CSS . '/' . $file . '" />' . "\n";
	}
	
	/**
	* load_menu()
	* Carrega menu da aplicação. O menu é um componente html de mesmo nome, localizado em
	* views/TEMPLATE-ATUAL/_includes/html_components/menu/menu.php.
	* @return string html_menu
	*/
	public function load_menu()
	{
		return $this->load_html_component('menu', array($this->get_array_menus()));
	}
	
	/**
	* load_user_info()
	* Carrega componente html de informacoes do usuario, como imagem, login, email, etc.
	* @return string user_info
	*/
	public function load_user_info()
	{
		$this->CI->load->library('session');
				
		// info do usuario vem da sessão
		$args['id_user'] = $this->CI->session->userdata('id_user');
		$args['login'] = $this->CI->session->userdata('login');
		$args['email'] = $this->CI->session->userdata('email');
		$args['user_name'] = $this->CI->session->userdata('user_name');
		$args['user_group'] = $this->CI->session->userdata('user_group');
		$args['user_img'] = $this->CI->session->userdata('user_img');
		
		return $this->load_html_component('user_info', $args);
	}

	/**
	* load_logo_area()
	* Carrega componente html do logotipo da aplicação. O link do logo redireciona para a página 
	* inicial do usuário.
	* @return string html_logo
	*/
	public function load_logo_area()
	{
		$url = $this->CI->session->userdata('url_default');
		
		// Retorna o html do componente logo
		return $this->load_html_component('logo_area', array($url));
	}

	/**
	* app_settings_inputs()
	* Retorna configurações da aplicação em formato de input tipo hidden.
	* @return string html_inputs
	*/
	public function app_settings_inputs()
	{
		$return = '';
		$escape = array();

		// Retorno só cria variáveis fora do escape
		foreach($this->CI->config->config['app_settings'] as $attribute => $value)
			if(!is_object($value))
				$return .= (!in_array($attribute, $escape) || !$protected_mode) ? "<input type=\"hidden\" name=\"$attribute\" id=\"$attribute\" value=\"" . tag_replace($value) . "\" />\n" : '';
		
		// Retorno
		return $return;
	}
	
	/**
	* message()
	* Retorna o componente html mensagem, que é montado conforme parametros encaminhados.
	* @param string tipo
	* @param string titulo
	* @param string descricao
	* @param boolean close
	* @param string style
	* @return string html_message
	*/
	public function message($type = 'info', $title = '', $description = '', $close = false, $style = '')
	{
		return $this->load_html_component('message_', array($type, $title, $description, $close, $style));
	}
	
	/**
	* get_array_menus()
	* Return application menus (located in database) in array/tree format.
	* @return string group [optional]
	* @return array menus
	*/
	public function get_array_menus($group = '')
	{
		$this->CI->load->model('libraries/template_model');
		
		$group = $group != '' ? $group : $this->CI->session->userdata('user_group');

		$menus = $this->CI->template_model->get_menus($group);
		
		return (count($menus) > 0) ? $this->menus_to_tree($menus) : array();
	}

	/**
	* menus_to_tree()
	* Recebe um conjunto de dados de array organizados por ordem de parent e os organiza
	* em formato de árvore (utilizado para construção de menus).
	* @param array menus
	* @return array menus_tree
	*/
	public function menus_to_tree(&$menus) 
	{
		$map = array(
			0 => array('childen' => array())
		);

		foreach ($menus as &$menu) {
			$menu['children'] = array();
			$map[get_value($menu, 'id_menu')] = &$menu;
		}

		foreach ($menus as &$menu) {
			$map[get_value($menu, 'id_menu_parent')]['children'][] = &$menu;
		}

		return $map[0]['children'];
	}
}