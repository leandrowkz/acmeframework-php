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

		// $script = file_get_contents('application/core/acme/engine_files/installer_dump_database/oci8/_teste.sql');

		// $statements = explode('<<|SEPARATOR|>>', $script);

		// foreach($statements as $sql) {
		// $sql = trim($sql, " \t\n\r\0\x0B");
			
		// if(stristr($sql, "CREATE OR REPLACE TRIGGER") !== false)
		// 	$sql .= "\n\n/";

		// 	echo utf8_decode($sql) . "\n\n\n\n";
			
		// 	//$stid = oci_parse($conn, $sql);
		//  	//oci_execute($stid);
			
		// }
		// die;
		//oci_close($conn);
		
		// echo tag_replace('{URL_ROOT}/acme_dashboard asdhgfhasdfha hh ds {URL_IMG} and echo {URL_CSS}');

		// Coleta nome de usuário
		$args['login_user'] = $this->session->userdata('login_user');
		$this->session->unset_userdata('login_user');
	
		// Coleta possivel mensagem de erro de login
		$args['login_msg_error'] = $this->session->userdata('login_msg_error');
		$this->session->unset_userdata('login_msg_error');
		
		// Booleano se o erro de login está no campo usuário
		$args['bool_user_error'] = $this->session->userdata('bool_user_error');
		$this->session->unset_userdata('bool_user_error');
		
		// Booleano se o erro de login está no campo senha
		$args['bool_pass_error'] = $this->session->userdata('bool_pass_error');
		$this->session->unset_userdata('bool_pass_error');
		
		// Carrega pagina view do form de login
		$this->template->load_page('login', $args, false, false);
	}
	
	/**
	* login_process()
	* Processa o formulário de login/entrada do sistema. Após validado,
	* joga o usuário para a página inicial configurada em seu cadastro.
	* @return void
	*/
	public function login_process()
	{
		$login_user = $this->input->post('user');
		$login_pass = $this->input->post('pass');
		
		// Coleta dados do usuário 'validado'
		$user = $this->access->validate_login($login_user, $login_pass);

		// Caso usuario nao exista, redireciona para pagina de login
		if(!$user)
		{
			// Monta mensagem correta de erro
			if($login_user == '')
			{
				$this->session->set_userdata('login_user', $login_user);
				$this->session->set_userdata('bool_user_error', true);
				$this->session->set_userdata('login_msg_error', lang('Insira seu nome de usuário.'));
			}
			
			if($login_user != '')
			{
				$this->session->set_userdata('login_user', $login_user);
				$this->session->set_userdata('bool_user_error', true);
				$this->session->set_userdata('login_msg_error', lang('O usuário ou senha informados estão incorretos.'));
			}
			
			redirect($this->controller_name);
		} else {
			// Verifica se url_Default do usuario está preenchida
			// e o redireciona para lá, caso contrário joga para pagina
			// padrao de listagem de modulos e atalhos do codeigniter
			$url_default = (get_value($user, 'url_default') != '') ? $this->tag->tag_replace(get_value($user, 'url_default')) : URL_ROOT . '/app_dashboard/';
			
			// Variaveis de informacao de usuario e sessao que vao para sessao
			$arr_session['id_user'] = get_value($user, 'id_user');
			$arr_session['user_group'] = get_value($user, 'user_group');
			$arr_session['user_name'] = get_value($user, 'user_name');
			$arr_session['login'] = get_value($user, 'login');
			$arr_session['user_img'] = tag_replace(get_value($user, 'url_img'));
			$arr_session['language'] = get_value($user, 'lang_default');
			$arr_session['url_default'] = $url_default;
			$arr_session['login_access'] = true;
			
			// Seta variáveis na sessão
			$this->session->set_userdata($arr_session);
			
			// Loga registro de login
			$this->log->db_log('login', 'login');
			
			// Redireciona para url do usuario
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
		$this->load->library('session');
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
	* Tela de solicitação de alteração de senha. Esqueci senha.
	* @return void
	*/
	public function forgot_password()
	{
		// Carrega pagina view do form de login
		$this->template->load_page($this->view_dir . '/forgot_password', array(), false, false);
	}
	
	/**
	* forgot_password_process()
	* Processa tela de solicitação de alteração de senha.
	* @return void
	*/
	public function forgot_password_process()
	{
		if($this->input->post('login') != '' && $this->input->post('validate_human') != '')
		{
			// Login informado
			$login = $this->input->post('login');
			
			// Tenta coletar dados pelo login
			$user = $this->db->get_where('acm_user', array('login' => $login))->result_array();
			$user = isset($user[0]) ? $user[0] : array();

			// Passa para view e gera chave de acesso para reset de senha
			$args['user'] = $user;
			$args['key_access'] = md5(uniqid());
			
			// Verifica se usuário existe
			if(count($user) > 0)
			{
				// Usuario existe
				$args['user_exist'] = true;
				
				// Tenta enviar email para usuário
				// caso falhe, nao faz insert na tabela de log de resets
				$message_body = $this->template->load_page('_acme/app_user/email_body_message_reset_password', $args, true, false);
				
				// Faz o envio, definitivamente
				if($this->app_email->send_email(lang('Solicitação de Alteração de Senha'), $message_body, get_value($user, 'email')))
				{
					// Seta controle OK
					$args['sent_email'] = true;
					
					// Insere log de solicitação de alteração de senha
					$arr_ins['id_user'] = get_value($user, 'id_user');
					$arr_ins['email'] = get_value($user, 'email');
					$arr_ins['key_access'] = $args['key_access'];
					$this->db->insert('acm_user_reset_password', $arr_ins);
				} else {
					$args['sent_email'] = false;
				}
			} else {
				$args['sent_email'] = false;
				$args['user_exist'] = false;
			}

			// Carrega view
			$this->template->load_page($this->view_dir . '/forgot_password_process', $args, false, false);
		} else {
			redirect($this->controller_name . '/forgot_password');
		}
	}
	
	/**
	* reset_password()
	* Tela de acesso ao reset de senha do usuário com base em uma chave de acesso e id_user.
	* @param int id_user
	* @param string key_access
	* @return void
	*/
	public function reset_password($id_user = 0, $key_access = '')
	{
		if($id_user != '' && $key_access != '')
		{
			$data = $this->db->get_where('acm_user_reset_password', array('id_user' => $id_user, 'key_access' => $key_access));
			$reset_pass = $data->result_array();
			$args['reset_pass'] = (isset($reset_pass[0])) ? $reset_pass[0] : array();
			$args['allow_update'] = (count($args['reset_pass']) > 0 && get_value($args['reset_pass'], 'dtt_updated') == '') ? true : false;
			// Carrega pagina view da tela de reset de senha
			$this->template->load_page($this->view_dir . '/reset_password', $args, false, false);
		} else {
			redirect($this->controller_name . '/login');
		}
	}
	
	/**
	* reset_password_process()
	* Processa tela de acesso ao reset de senha do usuário.
	* @return void
	*/
	public function reset_password_process()
	{
		$id_user = $this->input->post('id_user');
		$key_access = $this->input->post('key_access');
		$password = $this->input->post('password');
		$password_repeat = $this->input->post('password_repeat');
		if($id_user != '' && $key_access != '' && $password != '' && $password_repeat != '' && ($password == $password_repeat))
		{
			$data = $this->db->get_where('acm_user_reset_password', array('id_user' => $id_user, 'key_access' => $key_access));
			$reset_pass = $data->result_array();
			$args['reset_pass'] = (isset($reset_pass[0])) ? $reset_pass[0] : array();
			
			// Somente faz o reset de senha caso exista o id do usuario (validacao anti ataque)
			if(count($args['reset_pass']) > 0)
			{
				// Marca o link como atualizado
				$this->db->set('dtt_updated', 'CURRENT_TIMESTAMP', false);
				$this->db->where(array('id_user' => $id_user, 'key_access' => $key_access));
				$this->db->update('acm_user_reset_password');
				
				// Altera a senha de usuário
				$this->db->set('password', md5($password));
				$this->db->where(array('id_user' => $id_user));
				$this->db->update('acm_user');
				
				// Carrega pagina view da tela de reset de senha
				$this->template->load_page($this->view_dir . '/reset_password_process', $args, false, false);
			} else {
				redirect($this->controller_name . '/login');
			}
		} else {
			redirect($this->controller_name . '/login');
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
