<?php
/**
 * --------------------------------------------------------------------------------------------------
 * Library Template
 *
 * Gathers methods related with application template.
 *
 * @since 	10/09/2012
 * --------------------------------------------------------------------------------------------------
 */
class Template {

	/**
	 * CI controller instance.
	 * @var object
	 */
	public $CI = null;

	/**
	 * Class constructor.
	 */
	public function __construct()
	{
		$this->CI =& get_instance();
	}

	/**
	 * Loads a view script layer based on current template.
	 *
	 * @param string page
	 * @param array vars
	 * @param boolean return_html
	 * @param boolean load_master_page
	 * @return mixed
	 */
	public function load_view($page = '', $arr_vars = array(), $return_html = false, $load_master_page = true)
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
	 * Alias for load_view().
	 * Keeped for compatibility reasons.
	 *
	 * @param string page
	 * @param array vars
	 * @param boolean return_html
	 * @param boolean load_master_page
	 * @return mixed
	 */
	public function load_page($page = '', $arr_vars = array(), $return_html = false, $load_master_page = true)
	{
		if ( ! $return_html)
			$this->load_view($page, $arr_vars, $return_html, $load_master_page);
		else
			return $this->load_view($page, $arr_vars, $return_html, $load_master_page);
	}

	/**
	 * Loads a HTML component located inside the path defined by PATH_HTML_COMPONENTS
	 * constant. The second parameter is all variables must be available inside this
	 * component.
	 *
	 * @param string component
	 * @param array params
	 * @return string html_menu
	 */
	public function load_html_component($component = '', $params = array())
	{
		$path = str_replace('application/views/' . TEMPLATE . '/', '', PATH_HTML_COMPONENTS);

		return $this->load_view($path . '/' . $component . '/' . $component, $params, true, false);
	}

	/**
	 * Returns the HTML of tag <script src="$file"> according the forwarded file. It is
	 * necessary only the file name.
	 *
	 * @param string file
	 * @return string html
	 */
	public function load_js_file($file = '')
	{
		return '<script src="' . $file . '"></script>';
	}

	/**
	 * Returns the HTML of tag <link href="$file"> according the forwarded file. It is
	 * necessary only the file name.
	 *
	 * @param string file
	 * @return string html
	 */
	public function load_css_file($file = '')
	{
		return '<link href="' . $file . '" type="text/css" rel="stylesheet" />';
	}

	/**
	 * Loads the application menu. The app menu is an HTML component placed inside
	 * the path defined by PATH_HTML_COMPONENTS constant.
	 *
	 * @return string html_menu
	 */
	public function load_menu()
	{
		return $this->load_html_component('menu', array('menus' => $this->get_array_menus()));
	}

	/**
	 * Loads the user info HTML component. This component is placed inside the path
	 * defined by PATH_HTML_COMPONENTS constant and is composed by name, email,
	 * language, group, etc.
	 *
	 * @return string user_info
	 */
	public function load_user_info()
	{
		// User info comes from session
		$args['id_user'] = $this->CI->session->userdata('id_user');
		$args['login'] = $this->CI->session->userdata('login');
		$args['email'] = $this->CI->session->userdata('email');
		$args['user_name'] = $this->CI->session->userdata('user_name');
		$args['user_group'] = $this->CI->session->userdata('user_group');
		$args['user_img'] = $this->CI->session->userdata('user_img');

		return $this->load_html_component('user-info', $args);
	}

	/**
	 * Loads the application logo area. The logo area is an HTML component placed
	 * inside de path defined by PATH_HTML_COMPONENTS constant and represents the
	 * application brand.
	 *
	 * @return string html_logo
	*/
	public function load_logo_area()
	{
		$args['url'] = $this->CI->session->userdata('url_default');
		return $this->load_html_component('logo-area', $args);
	}

	/**
	 * Returns a set of HTML hidden inputs, each one for each app setting
	 * as APP_NAME, TEMPLATE, etc.
	 *
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
			require ('application/core/engine-files/installer_app_settings.php');

		// Just creates the input if it is safe or is not an object
		foreach($config as $attribute => $value)
			if(!is_object($value))
				$return .= (!in_array($attribute, $escape) || !$protected_mode) ? "<input type=\"hidden\" name=\"$attribute\" id=\"$attribute\" value=\"" . tag_replace($value) . "\" />\n" : '';

		// Returns
		return $return;
	}

	/**
	 * Returns the HTML of a message according with forwarded parameters.
	 *
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
	 * Returns the HTML component image, which is responsible for building an
	 * <img> tag, also checking ifthe given value is a font-awesome icon.
	 *
	 * @param string url_img
	 * @return string html
	 */
	public function image($url_img = '')
	{
		return $this->load_html_component('image', array('url_img' => $url_img));
	}

	/**
	 * Returns all application menus in array/tree format (comes from table acm_menu).
	 *
	 * @return string group [optional]
	 * @return array menus
	 */
	public function get_array_menus($group = '')
	{
		$group = $group != '' ? $group : $this->CI->session->userdata('user_group');
		$menus = $this->get_menus($group);
		return (count($menus) > 0) ? $this->menus_to_tree($menus) : array();
	}

	/**
	 * Transform an array resultset from database into a tree format (used to
	 * build application menu).
	 *
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

	/**
	 * Return all available application menus for an user according with given group.
	 *
	 * @param string user_group
	 * @return array menus
	 */
	public function get_menus($user_group = '')
	{
		// Build query according with driver
		switch(strtolower(DB_DRIVER))
		{
			// MySQL driver
			case 'mysql':
			case 'mysqli':
				$sql = "SELECT m.*,
							   IFNULL(id_menu_parent, 0) AS id_menu_parent
						  FROM acm_menu m
					INNER JOIN acm_user_group ug ON (m.id_user_group = ug.id_user_group)
						 WHERE ug.name = '$user_group'
					  ORDER BY m.id_menu_parent, m.order_";
			break;

			// Postgre driver
			case 'postgre':
				$sql = "SELECT m.*,
							   COALESCE(id_menu_parent, 0) AS id_menu_parent
						  FROM acm_menu m
					INNER JOIN acm_user_group ug ON (m.id_user_group = ug.id_user_group)
						 WHERE ug.name = '$user_group'
					  ORDER BY m.id_menu_parent, m.order_";
			break;

			// Oracle driver
			case 'oci8':
				$sql = "SELECT m.*,
							   NVL(id_menu_parent, 0) AS id_menu_parent
						  FROM acm_menu m
					INNER JOIN acm_user_group ug ON (m.id_user_group = ug.id_user_group)
						 WHERE ug.name = '$user_group'
					  ORDER BY m.id_menu_parent, m.order_";
			break;
		}

		// Load database connection
		$this->CI->load->database();

		// Run SQL and return data
		return $this->CI->db->query($sql)->result_array();
	}
}