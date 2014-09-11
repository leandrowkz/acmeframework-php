<?php
/**
* --------------------------------------------------------------------------------------------------
*
* Library Template
*
* Gathers methods related with application template.
* 
* @since 	10/09/2012
*
* --------------------------------------------------------------------------------------------------
*/
class Template {
	
	public $CI = null;
	
	/**
	* __construct()
	* Class constructor.
	*/
	public function __construct()
	{
		$this->CI =& get_instance();
	}
	
	/**
	* load_page()
	* Loads a view script based on current template.
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
	* Loads a HTML component, located at 
	* application/views/TEMPLATE/_includes/html_components/$component/$component.php
	* The second parameter is all variables must be available inside this component.
	* @param string component
	* @param array params
	* @return string html_menu
	*/
	public function load_html_component($component = '', $params = array())
	{
		$path = str_replace('application/views/' . TEMPLATE . '/', '', PATH_HTML_COMPONENTS);

		return $this->load_page($path . '/' . $component . '/' . $component, $params, true, false);	
	}
	
	/**
	* load_js_file()
	* Returns the HTML of tag <script src="$file"> according the forwarded file. It is
	* necessary only the file name. 
	* @param string file
	* @return string html
	*/
	public function load_js_file($file = '')
	{
		return '<script src="' . URL_JS . '/' . $file . '"></script>' . "\n";
	}
	
	/**
	* load_css_file()
	* Returns the HTML of tag <link href="$file"> according the forwarded file. It is
	* necessary only the file name.
	* @param string file
	* @return string html
	*/
	public function load_css_file($file = '')
	{
		return '<link type="text/css" rel="stylesheet" href="' . URL_CSS . '/' . $file . '" />' . "\n";
	}
	
	/**
	* load_menu()
	* Loads the application menu. The app menu is an HTML component placed at
	* application/views/TEMPLATE/_includes/html_components/menu/menu.php.
	* @return string html_menu
	*/
	public function load_menu()
	{
		return $this->load_html_component('menu', array('menus' => $this->get_array_menus()));
	}
	
	/**
	* load_user_info()
	* Loads the user info HTML component. This component is placed at
	* application/views/TEMPLATE/_includes/html_components/user_info/user_info.php
	* and is composed by name, email, language, group, etc.
	* @return string user_info
	*/
	public function load_user_info()
	{
		$this->CI->load->library('session');
				
		// user info comes from session
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
	* Loads the application logo area. The logo area is an HTML component placed at
	* application/views/TEMPLATE/_includes/html_components/logo_area/log_area.php and 
	* represents the application brand.
	* @return string html_logo
	*/
	public function load_logo_area()
	{
		$args['url'] = $this->CI->session->userdata('url_default');
		
		return $this->load_html_component('logo_area', $args);
	}

	/**
	* app_settings_inputs()
	* Returns a set of HTML hidden inputs, each one for each app setting as APP_NAME, TEMPLATE, etc.
	* @return string html_inputs
	*/
	public function app_settings_inputs()
	{
		$return = '';
		$escape = array();

		// Gets a single controller
		$CI = get_instance();

		// Loads properly configs
		if($CI->acme_installed)
			$config = $this->CI->config->config['app_settings'];
		else
			require ('application/core/acme/engine_files/installer_app_settings.php');

		// Just creates the input if it is safe or is not an object
		foreach($config as $attribute => $value)
			if(!is_object($value))
				$return .= (!in_array($attribute, $escape) || !$protected_mode) ? "<input type=\"hidden\" name=\"$attribute\" id=\"$attribute\" value=\"" . tag_replace($value) . "\" />\n" : '';
		
		// Returns
		return $return;
	}
	
	/**
	* message()
	* Returns the HTML of a message according with forwarded parameters.
	* @param string type 	// danger|error, warning, info, success, note, primary, default
	* @param string title
	* @param string description
	* @param boolean close
	* @param string style
	* @return string html
	*/
	public function message($type = 'info', $title = '', $description = '', $close = false, $style = '')
	{
		$args['type'] = $type;
		$args['title'] = $title;
		$args['description'] = $description;
		$args['close'] = $close;
		$args['style'] = $style;

		return $this->load_html_component('message', $args);
	}

	/**
	* image()
	* Returns the HTML component image, which is responsible for building an img tag, also checking if
	* the given value is a font-awesome icon.
	* @param string url_img
	* @return string html
	*/
	public function image($url_img = '')
	{
		return $this->load_html_component('image', array('url_img' => $url_img));
	}
	
	/**
	* get_array_menus()
	* Returns all application menus in array/tree format (comes from table acm_menu).
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
	* Receives an array resultset from database and convert it on a tree format (used
	* to build application menu).
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