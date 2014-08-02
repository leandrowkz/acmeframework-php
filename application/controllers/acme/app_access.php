<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* --------------------------------------------------------------------------------------------------
*
* Controller App_Access
* 
* Módulo de acesso a aplicação. Gerencia entrada e saída (login/logout) e páginas externas.
*
* @since	01/10/2012
*
* --------------------------------------------------------------------------------------------------
*/
class App_Access extends ACME_Core_Controller {
	
	public $view_dir = '';
	public $controller_name = '';
	
	/**
	* __construct()
	* Construtor de classe.
	* @return object
	*/
	public function __construct()
	{
		parent::__construct();
		$this->view_dir = '_acme/app_access';
		$this->controller_name = 'app_access';
	}
	
	/**
	* index()
	* Método 'padrão' do controlador. Carrega action da tela de login.
	* @return object
	*/
	public function index()
	{
		$this->login();
	}
	
	/**
	* login()
	* Tela de login.
	* @return void
	*/
	public function login()
	{
		// echo $note;
		//echo md5('123456');

		// $conn = oci_connect('tapmanager', 'tapmanager', 'localhost/XE');

		/*
		$script = file_get_contents('application/core/acme/engine_files/installer_dump_' . DB_DRIVER . '.sql');

		$statements = explode('<<|SEPARATOR|>>', $script);

		foreach($statements as $sql) {
			$sql = trim($sql, " \t\n\r\0\x0B");
			
		if(stristr($sql, "CREATE OR REPLACE TRIGGER") !== false)
			$sql .= "\n\n/";

		echo utf8_decode($sql) . "\n\n\n\n";
			
		//  	//$stid = oci_parse($conn, $sql);
		// //  	//oci_execute($stid);
			
		}
		die;
		*/
		
		//oci_close($conn);
		
		// echo tag_replace('{URL_ROOT}/acme_dashboard asdhgfhasdfha hh ds {URL_IMG} and echo {URL_CSS}');

		// Coleta nome de usuário
		$args['email_user'] = $this->session->userdata('email_user');
		$this->session->unset_userdata('email_user');
	
		// Coleta possivel mensagem de erro de login
		$args['email_msg_error'] = $this->session->userdata('email_msg_error');
		$this->session->unset_userdata('email_msg_error');
		
		// Booleano se o erro de login está no campo usuário
		$args['bool_email_error'] = $this->session->userdata('bool_email_error');
		$this->session->unset_userdata('bool_email_error');
		
		// Carrega pagina view do form de login
		$this->template->load_page('login', $args, false, false);
	}
	
	/**
	* login_process()
	* Process login page/form. After validate login, redirect user to his home.
	* @return void
	*/
	public function login_process()
	{
		$email = $this->input->post('email');
		$pass = $this->input->post('pass');
		
		// Try to get the user by email and pass 
		$user = $this->access->validate_login($email, $pass);

		// Case user doesnt exist, redirect to login page again
		if( ! $user ) {

			// Error message
			$this->session->set_userdata('email_user', $email);
			$this->session->set_userdata('bool_email_error', true);
			

			if ( $email == '' )
				$this->session->set_userdata('email_msg_error', lang('Insira seu nome de usuário.'));
			elseif ( $email != '' )
				$this->session->set_userdata('email_msg_error', lang('O usuário ou senha informados estão incorretos.'));
			
			
			redirect($this->controller_name);

		} else {
			// Check url's default for user, if not exist try to redirect to default dashboard
			$url_default = (get_value($user, 'url_default') != '') ? $this->tag->tag_replace(get_value($user, 'url_default')) : URL_ROOT . '/app_dashboard/';
			
			// Put some user data to session
			$session['id_user'] = get_value($user, 'id_user');
			$session['user_group'] = get_value($user, 'user_group');
			$session['user_name'] = get_value($user, 'user_name');
			$session['email'] = get_value($user, 'email');
			$session['user_img'] = tag_replace(get_value($user, 'url_img'));
			$session['language'] = get_value($user, 'lang_default');
			$session['url_default'] = $url_default;
			$session['login_access'] = true;
			
			// Set the data above
			$this->session->set_userdata($session);
			
			// Log the login
			$this->log->db_log('login', 'login');
			
			// Redirect to user's home
			redirect($url_default);
		}
	}
	
	/**
	* logout()
	* Saída do sistema.
	* @return void
	*/
	public function logout()
	{
		$this->session->sess_destroy();
		redirect($this->controller_name);
	}
	
	/**
	* not_found()
	* 404, página não encontrada.
	* @return void
	*/
	public function not_found()
	{
		$this->error->show_404();
	}
	
	/**
	* forgot_password()
	* Requirement new pass form for users.
	* @param boolean process
	* @return void
	*/
	public function forgot_password($process = false)
	{
		if( ! $process)
			$this->template->load_page($this->view_dir . '/forgot_password', array(), false, false);
		else {
			
			// collect email and validation
			$email = $this->input->post('email');
			$validate = $this->input->post('validate_human');

			// check consistency
			if($email == '' || $validate == '')
				redirect($this->controller_name . '/forgot_password');

			// try to find user data
			$user = $this->db->get_where('acm_user', array('email' => $email))->row_array(0);

			// user doesnt exist
			if( count($user) <= 0 )
				$this->template->load_page($this->view_dir . '/forgot_password', array('error' => lang('Ops! Nenhum usuário cadastrado com este email')), false, false);
			
			else {

				$args['user'] = $user;
				$args['id_user'] = get_value($user, 'id_user');
				$args['key_access'] = md5(uniqid());
				
				// collect email body msg
				$body_msg = $this->template->load_page('_acme/app_user/email_reset_password', $args, true, false);
				
				// now try to send email
				$this->load->library('email');
				$this->email->clear();
			    $this->email->to(get_value($user, 'email'));
			    $this->email->from(EMAIL_FROM, APP_NAME);
			    $this->email->subject(lang('Alteração de senha'));
			    $this->email->message($body_msg);
			    
			    if( ! @$this->email->send() ) 
					$this->template->load_page($this->view_dir . '/forgot_password', array('error' => lang('Ops! Não foi possível enviar a mensagem de email')), false, false);
				else {

					// log asking for reset pass
					$data['id_user'] = $args['id_user'];
					$data['key_access'] = $args['key_access'];

					$this->log->db_log(lang('Solicitação de Alteração de Senha'), 'reset_password', '', $data);

					// load page success!
					$this->template->load_page($this->view_dir . '/forgot_password', array('success' => lang('Feito! Uma mensagem contendo os passos para a alteração da senha foi encaminhada para ') . $email), false, false);

				}
			}
		}
	}
	
	/**
	* reset_password()
	* Form to reset user password. The parameters (iduser, key_access) must be valid in order to get access to this form.
	* The second parameter says to process this same form.
	* @param int id_user
	* @param string key_access
	* @param boolean process
	* @return void
	*/
	public function reset_password($id_user = 0, $key_access = '', $process = false)
	{
		if($id_user == '' || $key_access == '')
			redirect($this->controller_name);

		// var to check if exist any valid log
		$valid = false;
		$id_log = 0;

		// collect all reset_passwords logs
		$data = $this->db->get_where('acm_log', array('action' => 'reset_password'))->result_array();

		// loop all logs, trying to find a valid reset password log
		foreach ($data as $log) {
			
			$reset = json_decode(get_value($log, 'additional_data'), true);

			if(get_value($reset, 'id_user') == $id_user && get_value($reset, 'key_access') == $key_access) {
				$valid = true;
				$id_log = get_value($log, 'id_log');
				break;
			}
		}

		// well, this is not a valid token or this reset already used
		if( ! $valid)
			redirect($this->controller_name);

		// this is not a process action
		if( ! $process)
			$this->template->load_page($this->view_dir . '/reset_password', array('id_user' => $id_user, 'key_access' => $key_access), false, false);
		else {

			// get user's new pass
			$password = $this->input->post('password');
			$p_repeat = $this->input->post('password_repeat');

			// bad passwords
			if($password == '' || $p_repeat == '' || $password != $p_repeat)
				redirect($this->controller_name);
			
			// update user data
			$this->db->update('acm_user', array('password' => md5($password)), array('id_user' => $id_user));

			// delete log
			$this->db->delete('acm_log', array('id_log' => $id_log));

			// load view (update ok)
			$this->template->load_page($this->view_dir . '/reset_password', array('id_user' => $id_user, 'key_access' => $key_access, 'success' => lang('Feito! Senha alterada com sucesso')), false, false);
		}
	}
	
	/**
	* check_session()
	* Verifica sessão (se está ativa, usuário logado) e retorna resposta em json.
	* @return string json
	*/
	public function check_session()
	{
		$json = array('check_session' => $this->access->check_session());
		echo json_encode($json);
	}
}
