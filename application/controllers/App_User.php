<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * --------------------------------------------------------------------------------------------------
 * Controller App_User
 *
 * Application users module. Manage users and groups with this module.
 *
 * @since	13/08/2012
 * --------------------------------------------------------------------------------------------------
 */
class App_User extends ACME_Controller {

	public $photos_dir = 'user-photos';

	/**
	 * Class constructor.
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Application users list.
	 *
	 * @return void
	 */
	public function index()
	{
		$this->validate_permission('ENTER');

		// Get users
		$args['users'] = $this->app_user_model->get_users();

		// Load view
		$this->template->load_view( $this->controller . '/index', $args);
	}

	/**
	 * Application groups list.
	 *
	 * @return void
	 */
	public function groups()
	{
		$this->validate_permission('ENTER');

		// Get groups
		$args['groups'] = $this->db->get('acm_user_group')->result_array();

		// Load view
		$this->template->load_view( $this->controller . '/groups', $args);
	}

	/**
	 * Insert, update and delete for groups. Fowarded by groups page, through
	 * ajax. Operation must be sent as parameter and data by $_POST. Print
	 * json as result operation status.
	 *
	 * @param string operation		// insert, update, delete
	 * @return void
	 */
	public function save_group($operation = '')
	{
		if( ! $this->check_permission('ENTER')) {
			echo json_encode(array('return' => false, 'error' => lang('Ops! You do not have permission to do that.')));
			return;
		}

		switch(strtolower($operation)) {

			case 'insert':
			case 'update':

				$data['name'] = $this->input->post('name');
				$data['description'] = $this->input->post('description');

				if( strtolower($operation) == 'insert' )
					$this->db->insert('acm_user_group', $data);
				else
					$this->db->update('acm_user_group', $data, array('id_user_group' => $this->input->post('id_user_group')));

			break;

			case 'delete';
				// There are users in this group!
				if( $this->db->get_where('acm_user', array('id_user_group' => $this->input->post('id_user_group')))->num_rows() > 0 ) {
					echo json_encode(array('return' => false, 'error' => lang('Ops! There are users in this group.')));
					return;
				}

				$this->db->delete('acm_user_group', array('id_user_group' => $this->input->post('id_user_group')));
			break;
		}

		// Adorable return!
		echo json_encode(array('return' => true));
	}

	/**
	 * New user form page.
	 *
	 * @param boolean process
	 * @return void
	 */
	public function new_user($process = false)
	{
		$this->validate_permission('INSERT');

		// New user form
		if( ! $process) {

			$groups = $this->db->select('id_user_group, name')->from('acm_user_group')->order_by('name')->get()->result_array();

			$args['options'] = $this->form->build_select_options($groups);

			$this->template->load_view( $this->controller . '/new-user', $args);

		} else {

			// Proccess form
			$user_data['id_user_group'] = $this->input->post('id_user_group');
			$user_data['name'] = $this->input->post('name');
			$user_data['email'] = $this->input->post('email');
			$user_data['description'] = $this->input->post('description');
			$user_data['password'] = md5($this->input->post('password'));

			// Insert user
			$this->db->insert('acm_user', $user_data);

			// Get user in order to insert configs
			$user = $this->db->get_where('acm_user', array('email' => $user_data['email']))->row_array(0);

			// Insert configs to this user
			$config['id_user'] = get_value($user, 'id_user');
			$config['url_default'] = $this->input->post('url_default');
			$config['lang_default'] = $this->input->post('lang_default');

			$this->db->insert('acm_user_config', $config);

			// Redirect to config page
			redirect('app-user');
		}
	}

	/**
	 * Update user form.
	 *
	 * @param int id_user
	 * @param boolean process
	 * @return void
	 */
	public function edit($id_user = 0, $process = false)
	{
		$this->validate_permission('UPDATE');

		// Edit user form
		if( ! $process) {

			// User data
			$user = $this->app_user_model->get_user($id_user);

			// Check if user exist
			if( count($user) <= 0 )
				redirect('app-user');

			// Get all groups for select
			$groups = $this->db->select('id_user_group, name')->from('acm_user_group')->order_by('name')->get()->result_array();

			// Build options html
			$options = $this->form->build_select_options($groups, get_value($user, 'id_user_group'));

			// Vars for view
			$args['user'] = $user;
			$args['options'] = $options;

			$this->template->load_view( $this->controller . '/edit', $args);

		} else {

			// Proccess form
			$this->db->set('id_user_group', $this->input->post('id_user_group'));
			$this->db->set('name', $this->input->post('name'));
			$this->db->set('email', $this->input->post('email'));
			$this->db->set('description', $this->input->post('description'));

			// Checks if user is ROOT (you cannot disable it)
			if ( (integer) $id_user != 1 ) {

				// Basic check for status
				if($this->input->post('status') == '')
					$this->db->set('dtt_inative', date('Y-m-d'));
				else
					$this->db->set('dtt_inative', 'NULL', false);

			}

			// Where conditions
			$this->db->where(array('id_user' => $id_user));

			// Update user
			$this->db->update('acm_user');

			// Configs update
			$config['url_default'] = $this->input->post('url_default');
			$config['lang_default'] = $this->input->post('lang_default');

			$this->db->update('acm_user_config', $config, array('id_user' => $id_user));

			// Redirect to config page
			redirect('app-user');
		}
	}

	/**
	 * Permission manager for refered user id.
	 *
	 * @param integer id_user
	 * @return void
	 */
	public function permissions($id_user = 0)
	{
		$this->validate_permission('PERMISSION_MANAGER');

		// Get user data
		$user = $this->app_user_model->get_user($id_user);

		// Check if user exist
		if ( count($user) <= 0 )
			redirect('app-user');

		// Get all permissions for this user
		$permissions =  $this->app_user_model->get_permissions($id_user);

		// Vars for view
		$args['user'] = $user;
		$args['permissions'] = $permissions;

		// Load view
		$this->template->load_view( $this->controller . '/permissions', $args);
	}

	/**
	 * Validate an email passed by POST, checking if already exist an user with this email.
	 *
	 * @return void
	 */
	public function check_email()
	{
		$email = $this->input->post('email');

		if( $this->db->get_where('acm_user', array('email' => $email))->num_rows() > 0)
			echo json_encode(array('return' => true));
		else
			echo json_encode(array('return' => false));
	}

	/**
	 * Enable or disable permission for user. Fowarded by permissions page, through
	 * ajax. Operation must be sent as parameter and data by $_POST. Print json
	 * as result operation status.
	 *
	 * @param string operation		// enable, disable
	 * @return void
	 */
	public function save_permission($operation = '')
	{
		if( ! $this->check_permission('PERMISSION_MANAGER')) {
			echo json_encode(array('return' => false, 'error' => lang('Ops! You do not have permission to do that.')));
			return;
		}

		$id_user = $this->input->post('id_user');
		$id_module_permission = $this->input->post('id_module_permission');

		// Prevents user from uncheck some important permissions
		// ENTER users, manage PERMISSIONS
		if( (integer) $id_user == 1 ) {

			// Gets permission data
			$permission = $this->db->from('acm_module_permission mp')
								   ->join('acm_module m', 'm.id_module = mp.id_module')
								   ->where( array('id_module_permission' => $id_module_permission) )
								   ->get()
								   ->row_array(0);

			if( ( get_value($permission, 'permission') == 'ENTER'
			   || get_value($permission, 'permission') == 'PERMISSION_MANAGER' )
			   && strtolower(get_value($permission, 'controller')) == 'app_user' ) {

				echo json_encode( array('return' => false, 'error' => lang('Ops! You cannot disable this permission. For security reasons this permission must be always activated for this user.')) );
				return;
			}
		}

		// Formats data
		$data['id_user'] = $id_user;
		$data['id_module_permission'] = $id_module_permission;

		// Always delete permission to save another
		$this->db->delete('acm_user_permission', $data);

		if( strtolower($operation) == 'enable' )
			$this->db->insert('acm_user_permission', $data);

		// Adorable return!
		echo json_encode(array('return' => true));
	}

	/**
	 * Profile user page.
	 *
	 * @param integer id_user
	 * @return void
	 */
	public function profile($id_user = 0)
	{
		// Only the logged user can see your profile
		if($this->session->userdata('id_user') != $id_user || $id_user == '' || $id_user == 0)
			redirect($this->session->userdata('url_default'));

		// Load user data
		$args['user'] = $this->app_user_model->get_user($id_user);

		// Load view
		$this->template->load_view( $this->controller . '/profile', $args);
	}

	/**
	 * Form and process form of user profile.
	 *
	 * @param integer id_user
	 * @param boolean process
	 * @return void
	 */
	public function edit_profile($id_user = 0, $process = false)
	{
		// Only the logged user can see your profile
		if($this->session->userdata('id_user') != $id_user || $id_user == '' || $id_user == 0)
			redirect($this->session->userdata('url_default'));

		if( ! $process) {

			// Load user data
			$args['user'] = $this->app_user_model->get_user($id_user);

			// Load view
			$this->template->load_view( $this->controller . '/edit-profile', $args);
		} else {

			// Update user
			$user['name'] = $this->input->post('name');
			$user['description'] = $this->input->post('description');
			$this->db->update('acm_user', $user, array('id_user' => $id_user ));

			// Array de atualização de config de user
			$config['lang_default'] = $this->input->post('lang_default');
			$this->db->update('acm_user_config', $config, array('id_user' => $id_user ));

			// Redirect to profile
			redirect('app-user/profile/' . $id_user);
		}
	}

	/**
	 * Form to edit thumbnail image, upload, resize, etc.
	 *
	 * @param integer id_user
	 * @return void
	 */
	public function edit_photo($id_user = 0)
	{
		// Only the logged user can see your profile
		if($this->session->userdata('id_user') != $id_user || $id_user == '' || $id_user == 0)
			redirect($this->session->userdata('url_default'));

		// Load user data
		$args['user'] = $this->app_user_model->get_user($id_user);

		// Load view
		$this->template->load_view( $this->controller . '/edit-photo', $args);
	}

	/**
	 * Upload image and update on database, for current user.
	 *
	 * @param int id_user
	 * @return void
	 */
	public function upload_photo($id_user = 0)
	{
		// Only the logged user can see your profile
		if($this->session->userdata('id_user') != $id_user || $id_user == '' || $id_user == 0)
			redirect($this->session->userdata('url_default'));

		// Upload configs
		$config['upload_path'] = PATH_UPLOAD . '/' . $this->photos_dir;
		$config['file_name'] = $id_user . '_' . uniqid();
		$config['allowed_types'] = 'gif|jpg|png|jpeg';
		$config['max_width'] = '4500';
		$config['max_height'] = '4500';

		// Load library to upload
		$this->load->library('upload', $config);

		// Try to upload
		if ( ! $this->upload->do_upload('file'))
		{
			// Yeah, we have errors
			$return = $this->upload->display_errors("<error>", "</error>");

			// Force an header 400 (error)
			$this->output->set_status_header('400');
		}

		// Upload ok!!
		else {
			// User data
			$user = $this->app_user_model->get_user($id_user);

			// Name of new image
			$new_file = get_value($this->upload->data(), 'file_name');

			// Remove the previous user image
			@unlink(PATH_UPLOAD . '/' . $this->photos_dir . '/' . basename(get_value($user, 'url_img_large')));

			// Update currently image
			$this->db->update('acm_user_config', array('url_img_large' => '{URL_UPLOAD}/' . $this->photos_dir . '/' . $new_file), array('id_user' => $id_user));

			// New image to return
			$return = $new_file;
		}

		echo $return;
	}

	/**
	 * Update user thumbnail according to the coordinates.
	 *
	 * @return int id_user
	 * @return void
	 */
	public function edit_thumbnail($id_user = 0)
	{
		// Only the logged user can see your profile
		if($this->session->userdata('id_user') != $id_user || $id_user == '' || $id_user == 0)
			redirect($this->session->userdata('url_default'));

		// Coordinates of image
		$w = $this->input->post('w');
		$h = $this->input->post('h');
		$sw = $this->input->post('sw');
		$sh = $this->input->post('sh');
		$x1 = $this->input->post('x1');
		$x2 = $this->input->post('x2');
		$y1 = $this->input->post('y1');
		$y2 = $this->input->post('y2');

		// Make thumb only if coordinates are correct
		if($w != '' && $h != '' && $x1 != '' && $x2 != '' && $y1 != '' && $y2 != '' && $sw != '' && $sh != '')
		{
			// User data
			$user = $this->app_user_model->get_user($id_user);

			// Make thumb (return = thumb name)
			if(($file_thumb_name = $this->_make_thumbnail($id_user, basename(get_value($user, 'url_img_large')), $w, $h, $sw, $sh, $x1, $x2, $y1, $y2)) === false)
			{
				// Force header 400 (erro)
				$this->output->set_status_header('400');
			} else {
				// Remove previous thumb
				@unlink(PATH_UPLOAD . '/' . $this->photos_dir . '/' . basename(get_value($user, 'url_img')));

				// Update info on database
				$new_user_img = '{URL_UPLOAD}/' . $this->photos_dir . '/' . $file_thumb_name;
				$this->db->update('acm_user_config', array('url_img' => $new_user_img), array('id_user' => $id_user));

				// Update img on session
				$this->session->set_userdata('user_img', tag_replace($new_user_img));
			}
		}
	}

	/**
	 * Make a thumbnail from de coordinates and user info.
	 *
	 * @param string img
	 * @param int rw width of image resized (responsive)
	 * @param int rh height of image resized (responsive)
	 * @param int sw width of thumb selection
	 * @param int sh height of thumb selection
	 * @param int x1
	 * @param int x2
	 * @param int y1
	 * @param int y2
	 * @return mixed string filename / boolean error
	 */
	private function _make_thumbnail($id_user = 0, $lrg_image = '', $rw = 0, $rh = 0, $sw = 0, $sh = 0, $x1 = 0, $x2 = 0, $y1 = 0, $y2 = 0)
	{
		// Configs. of thumb
		$tw = 150;
		$th = 150;
		$tmb_ext = 'png';
		$tmb_file_name = $id_user . '_tmb_' . uniqid() . '.' . $tmb_ext;
		$tmb_path_file = PATH_UPLOAD . '/' . $this->photos_dir . '/' . $tmb_file_name;

		// Original img info (original, large)
		$lrg_path_file = PATH_UPLOAD . '/' . $this->photos_dir . '/' . $lrg_image;
		list($ow, $oh, $img_type) = getimagesize($lrg_path_file);

		// Recalculates points (scale, 3 rule)
		$nx1 = $ow * $x1 / $rw;
		$nx2 = $ow * $x2 / $rw;
		$ny1 = $oh * $y1 / $rh;
		$ny2 = $oh * $y2 / $rh;
		$nsw = $ow * $sw / $rw;
		$nsh = $oh * $sh / $rh;

		$img_type = image_type_to_mime_type($img_type);

		// Transforms original img into a source
		switch($img_type)
		{
			case 'image/gif':
				$lrg_image_source = imagecreatefromgif($lrg_path_file);
			break;

			case 'image/pjpeg':
			case 'image/jpeg':
			case 'image/jpg':
				$lrg_image_source = imagecreatefromjpeg($lrg_path_file);
			break;

			case 'image/png':
			case 'image/x-png':
			default:
				$lrg_image_source = imagecreatefrompng($lrg_path_file);
			break;
		}

		// Create the thumb according to height / width
		$tmb_source = imagecreatetruecolor($tw, $th);

		// Copy the selection info to thumbnail source
		imagecopyresampled($tmb_source, $lrg_image_source, 0, 0, $nx1, $ny1, $tw, $th, $nsw, $nsh);

		// Makes thumb on refered filepath
		if(imagepng($tmb_source, $tmb_path_file) === true)
			return $tmb_file_name;
		else
			return false;
	}

	/**
	 * Send an email to user by refered id, this email contains the steps to reset password.
	 *
	 * @param int id_user
	 * @return void
	 */
	public function reset_password($id_user = 0)
	{
		if( ! $this->check_permission('RESET_PASSWORD')) {
			echo json_encode(array('return' => false, 'error' => lang('Ops! You do not have permission to do that.')));
			return;
		}

		// User data
		$user = $this->app_user_model->get_user($id_user);
		$args['user'] = $user;
		$args['id_user'] = $id_user;
		$args['key_access'] = md5(uniqid());

		// Collect email body msg
		$body_msg = $this->template->load_view( $this->controller . '/email-reset-password', $args, true, false);

		// Now try to send email
		$this->load->library('email');
		$this->email->clear();
	    $this->email->to(get_value($user, 'email'));
	    $this->email->from(EMAIL_FROM, APP_NAME);
	    $this->email->subject(lang('Reset password'));
	    $this->email->message($body_msg);

	    if( ! @$this->email->send() ) {
			echo json_encode(array('return' => false, 'error' => lang('Ops! It was not possible to send the email message. Check the email settings and try again.')));
			return;
		}

		// Log asking for reset pass
		$data['id_user'] = $args['id_user'];
		$data['key_access'] = $args['key_access'];

		$this->logger->db_log(lang('Reset password request'), 'reset_password', '', $data);

		// Adorable return!
		echo json_encode(array('return' => true));
	}

	/**
	 * Password change page.
	 *
	 * @param integer id_user
	 * @param boolean process
	 * @return void
	 */
	public function change_password($id_user = 0, $process = false)
	{
		// Only the logged user can see your profile
		if($this->session->userdata('id_user') != $id_user || $id_user == '' || $id_user == 0)
			redirect($this->session->userdata('url_default'));

		// View vars
		$args['password_error'] = false;

		// Load user data
		$args['user'] = $this->app_user_model->get_user($id_user);

		if( ! $process) {

			// Load view
			$this->template->load_view( $this->controller . '/change-password', $args);

		} else {

			// Update user password
			$old_pass = md5($this->input->post('old_pass'));
			$new_pass = md5($this->input->post('new_pass'));
			$cnf_pass = md5($this->input->post('cnf_pass'));

			// Try to find user by old password and email
			$user = $this->db->get_where('acm_user', array('password' => $old_pass, 'id_user' => $id_user))->row_array(0);

			// Basic password check
			if($new_pass != $cnf_pass || count($user) <= 0)
				$args['password_error'] = true;

			if($args['password_error'])
				$this->template->load_view( $this->controller . '/change-password', $args);
			else {

				// Update pass on dtabase
				$upd_user['password'] = $new_pass;

				$this->db->update('acm_user', $upd_user, array('id_user' => $id_user));

				redirect('app-user/profile/' . $id_user);
			}
		}
	}
}
