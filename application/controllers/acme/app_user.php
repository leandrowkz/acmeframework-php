<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* --------------------------------------------------------------------------------------------------
*
* Controller App_User
* 
* Módulo de usuários da aplicação.
*
* @since	13/08/2012
*
* --------------------------------------------------------------------------------------------------
*/
class App_User extends ACME_Module_Controller {
	
	public $photos_dir = 'user_photos';
	
	/**
	* __construct()
	* Construtor de classe.
	* @return object
	*/
	public function __construct()
	{
		parent::__construct(__CLASS__);
	}
	
	/**
	* permission_manager()
	* Tela de gerenciamento de permissões de usuário.
	* @param integer id_user
	* @return void
	*/
	public function permission_manager($id_user = 0)
	{
		$this->validate_permission('PERMISSION_MANAGER');
		
		// Coleta filtros
		$filters = $this->input->post();
		
		// Calcula filtros para modulos (exibir somente modulos do acme ou app)
		$args['show_acme_modules'] = (get_value($filters, 'show_acme_modules') == 'Y') ? true : false;
		
		// Permission do usuario
		$args['lista'] =  $this->app_user_model->get_list_permissions($id_user, $args['show_acme_modules']);
		$args['user_data'] = $this->app_user_model->get_user_data($id_user);
		
		// Carrega view
		$this->template->load_page('_acme/app_user/permission_manager', $args);
	}
	
	/**
	* ajax_set_user_permission()
	* Habilita ou desabilita uma permissão de um módulo para determinado usuário
	* incluindo um novo registro ou deletando da tabela de permissões.
	* @param integer id_user
	* @param integer id_module_permission
	* @param string action
	* @return void
	*/
	public function ajax_set_user_permission($id_user = 0, $id_module_permission = 0, $action = '')
	{
		if($this->validate_permission('PERMISSION_MANAGER', false))
		{
			$permission_ins['id_user'] = $id_user;
			$permission_ins['id_module_permission'] = $id_module_permission;	
			
			// Dados para inserção
			if( strtolower($action) == 'enable')
			{				
				// Insere um novo registro de acao para este formulario
				$this->db->insert('acm_user_permission', $permission_ins);
			}else{					
				$this->db->delete('acm_user_permission', $permission_ins);
			}			
		}	
	}
	
	/**
	* profile()
	* Tela de perfil de usuário.
	* @param integer id_user
	* @return void
	*/
	public function profile($id_user = 0)
	{		
		// Carrega dados do usuário
		$user = $this->app_user_model->get_user_data($id_user);	
		
		$args['id_user'] = get_value($user, 'id_user');
		$args['login'] = get_value($user, 'login');
		$args['password'] = get_value($user, 'password');
		$args['name'] = get_value($user, 'name');
		$args['email'] = get_value($user, 'email');
		$args['description'] = get_value($user, 'description');
		$args['active'] = get_value($user, 'active');
		$args['log_dtt_ins'] = get_value($user, 'log_dtt_ins');
		$args['group'] = get_value($user, 'grup');
		$args['url_img'] = get_value($user, 'url_img');
		$args['url_default'] = get_value($user, 'url_default'); 
		$args['lang_default'] = get_value($user, 'lang_default'); 
		
		// Ranking de acessos por browsers
		$browser_rank = $this->app_user_model->browser_rank_user($id_user);
		$args['browser_rank'] = isset($browser_rank[0]) ? $browser_rank : array(0 => array());
		
		// Se tem permissão para edição
		$args['editable'] = ($this->validate_permission('EDIT_PROFILE', false) || $id_user == $this->session->userdata('id_user')) ? true : false;
		$this->template->load_page('_acme/app_user/profile', $args);
	}

	/**
	* edit_profile()
	* Tela de edição de perfil de usuário.
	* @param integer id_user
	* @return void
	*/
	public function edit_profile($id_user = 0)
	{		
		if(($this->validate_permission('EDIT_PROFILE', false) || $id_user == $this->session->userdata('id_user')) && $id_user != '' && $id_user != 0)
		{
			// Carrega dados do usuário
			$user = $this->app_user_model->get_user_data($id_user);	
			
			$args['id_user'] = get_value($user, 'id_user');
			$args['login'] = get_value($user, 'login');
			$args['password'] = get_value($user, 'password');
			$args['name'] = get_value($user, 'name');
			$args['email'] = get_value($user, 'email');
			$args['description'] = get_value($user, 'description');
			$args['active'] = get_value($user, 'active');
			$args['log_dtt_ins'] = get_value($user, 'log_dtt_ins');
			$args['group'] = get_value($user, 'grup');
			$args['url_img'] = get_value($user, 'url_img');
			$args['url_default'] = get_value($user, 'url_default'); 
						
			// Carrega view
			$this->template->load_page('_acme/app_user/edit_profile', $args);
		}
	}

	/**
	* edit_profile_process()
	* Processa tela de edição de perfil de usuário.
	* @return void
	*/
	public function edit_profile_process()
	{
		$id_user = $this->input->post('id_user');

		if(($this->validate_permission('EDIT_PROFILE', false) || $id_user == $this->session->userdata('id_user')) && $id_user != '' && $id_user != 0)
		{
			// Array de atualização de user
			$arr_usr['name'] = $this->input->post('name');
			$arr_usr['email'] = $this->input->post('email');
			$arr_usr['description'] = $this->input->post('description');
			$this->db->update('acm_user', $arr_usr, array('id_user' => $id_user ));

			// Array de atualização de config de user
			$arr_cnf['lang_default'] = $this->input->post('lang_default');
			$this->db->update('acm_user_config', $arr_cnf, array('id_user' => $id_user ));
			
			// Redireciona para profile
			redirect(URL_ROOT . '/app_user/profile/' . $id_user);
			exit;
		}
		
		redirect($this->session->userdata('url_default'));
	}

	/**
	* edit_photo()
	* Tela de edição de imagem de usuário (upload, resize, etc.).
	* @param integer id_user
	* @return void
	*/
	public function edit_photo($id_user = 0)
	{
		if(($this->validate_permission('EDIT_PROFILE', false) || $id_user == $this->session->userdata('id_user')) && $id_user != '' && $id_user != 0)
		{
			
			// Carrega dados do usuário
			$user = $this->app_user_model->get_user_data($id_user);	
			
			$args['id_user'] = get_value($user, 'id_user');
			$args['login'] = get_value($user, 'login');
			$args['password'] = get_value($user, 'password');
			$args['name'] = get_value($user, 'name');
			$args['email'] = get_value($user, 'email');
			$args['description'] = get_value($user, 'description');
			$args['active'] = get_value($user, 'active');
			$args['log_dtt_ins'] = get_value($user, 'log_dtt_ins');
			$args['group'] = get_value($user, 'grup');
			$args['url_img'] = get_value($user, 'url_img'); 
			$args['url_img_large'] = tag_replace(get_value($user, 'url_img_large'));
			$args['url_default'] = get_value($user, 'url_default'); 

			// Carrega view
			$this->template->load_page('_acme/app_user/edit_photo', $args);
		}
	}

	/**
	* upload_photo()
	* Envio de imagem de usuário. Apenas recebe a imagem e o id do usuário via POST
	* faz o upload da imagem e atualiza a imagem para o usuário no banco de dados.
	* @return void
	*/
	public function upload_photo()
	{
		$id_user = $this->input->post('id_user');
		
		if(($this->validate_permission('EDIT_PROFILE', false) || $id_user == $this->session->userdata('id_user')) && $id_user != '' && $id_user != 0)
		{
			// Configs de upload
			$config['upload_path'] = PATH_UPLOAD . '/' . $this->photos_dir;
			$config['file_name'] = $id_user . '_' . uniqid();
			$config['allowed_types'] = 'gif|jpg|png|jpeg';
			$config['max_width'] = '4500';
			$config['max_height'] = '4500';

			// Carrega lib de upload
			$this->load->library('upload', $config);
			
			// Tenta fazer upload 
			if ( ! $this->upload->do_upload('file'))
			{
				// Informa erro para retorno
				$return = $this->upload->display_errors("<error>", "</error>");
 				
				// Força header 400 (erro)
 				$this->output->set_status_header('400');
			} 
			
			// Upload ok!!
			else {
				// Dados do usuário
				$user = $this->app_user_model->get_user_data($id_user);
				
				// Nome da nova imagem 
				$new_file = get_value($this->upload->data(), 'file_name');
				
				// Remove imagem large anterior
				@unlink(PATH_UPLOAD . '/' . $this->photos_dir . '/' . basename(get_value($user, 'url_img_large')));

				// Atualiza imagem atual
				$this->db->update('acm_user_config', array('url_img_large' => '<app eval="URL_UPLOAD" />/' . $this->photos_dir . '/' . $new_file), array('id_user' => $id_user));

				// Informa nova img para retorno
				$return = $new_file;
			}

			echo $return;
		}
	}

	/**
	* edit_thumbnail()
	* Atualiza thumbnail da imagem atual de usuário.
	* @return void
	*/
	public function edit_thumbnail()
	{
		if(($this->validate_permission('EDIT_PROFILE', false) || $this->input->post('id_user') == $this->session->userdata('id_user')) && $this->input->post('id_user') != '' && $this->input->post('id_user') != '0')
		{
			// Coleta id usuario e coordenadas
			$id_user = $this->input->post('id_user');
			$w = $this->input->post('w');
			$h = $this->input->post('h');
			$sw = $this->input->post('sw');
			$sh = $this->input->post('sh');
			$x1 = $this->input->post('x1');
			$x2 = $this->input->post('x2');
			$y1 = $this->input->post('y1');
			$y2 = $this->input->post('y2');

			// Faz o thumb apenas se todas as infomações estiverem devidamente adequadas
			if($w != '' && $h != '' && $x1 != '' && $x2 != '' && $y1 != '' && $y2 != '' && $sw != '' && $sh != '')
			{
				// Coleta dados do usuário (para atualização posterior)
				$user = $this->app_user_model->get_user_data($id_user);
				
				// Gera o thumb devidamente (retorno = thumb name)
				if(($file_thumb_name = $this->_make_thumbnail($id_user, basename(get_value($user, 'url_img_large')), $w, $h, $sw, $sh, $x1, $x2, $y1, $y2)) === false)
				{
					// Força header 400 (erro)
 					$this->output->set_status_header('400');
				} else {
					// Remove thumb anterior
					@unlink(PATH_UPLOAD . '/' . $this->photos_dir . '/' . basename(get_value($user, 'url_img')));

					// Atualiza info do thumb do usuário
					$new_user_img = '<app eval="URL_UPLOAD" />/' . $this->photos_dir . '/' . $file_thumb_name;
					$this->db->update('acm_user_config', array('url_img' => $new_user_img), array('id_user' => $id_user));
					
					// Atualiza imagem da sessão
					$this->session->set_userdata('user_img', tag_replace($new_user_img));
				}
			}
		}
	}

	/**
	* _make_thumbnail()
	* Gera um thumbnail a partir da imagem atual do usuário e coordenadas encaminhadas.
	* @param string img
	* @param int rw Largura da imagem redimensionada (responsiva)
	* @param int rh Altura da imagem redimensionada (responsiva)
	* @param int sw Largura da seleção do thumb
	* @param int sh Altura da seleção do thumb
	* @param int x1
	* @param int x2
	* @param int y1
	* @param int y2
	* @return mixed string filename / boolean error
	*/
	private function _make_thumbnail($id_user = 0, $lrg_image = '', $rw = 0, $rh = 0, $sw = 0, $sh = 0, $x1 = 0, $x2 = 0, $y1 = 0, $y2 = 0)
	{
		// Configs. do thumb
		$tw = 150;
		$th = 150;
		$tmb_ext = 'png';
		$tmb_file_name = $id_user . '_tmb_' . uniqid() . '.' . $tmb_ext;
		$tmb_path_file = PATH_UPLOAD . '/' . $this->photos_dir . '/' . $tmb_file_name;

		// Informações da imagem encaminhada (original, large)
		$lrg_path_file = PATH_UPLOAD . '/' . $this->photos_dir . '/' . $lrg_image;
		list($ow, $oh, $img_type) = getimagesize($lrg_path_file);

		// Recalcula pontos (escala, regra de 3)
		$nx1 = $ow * $x1 / $rw;
		$nx2 = $ow * $x2 / $rw;
		$ny1 = $oh * $y1 / $rh;
		$ny2 = $oh * $y2 / $rh;
		$nsw = $ow * $sw / $rw;
		$nsh = $oh * $sh / $rh;

		$img_type = image_type_to_mime_type($img_type);
		
		// Converte a imagem original (large) em source
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
		
		// Cria o thumb com base na largura / altura 
		$tmb_source = imagecreatetruecolor($tw, $th);

		// Copia a seleção informada para o source do thumb
		imagecopyresampled($tmb_source, $lrg_image_source, 0, 0, $nx1, $ny1, $tw, $th, $nsw, $nsh);
		
		// Cria o thumb devidamente no path informado
		if(imagepng($tmb_source, $tmb_path_file) === true)
			return $tmb_file_name;
		else
			return false;
	}
	
	/**
	* insert()
	* Formulário customizado de inserção de usuário. Regras básicas:
	* -> Caso o usuário que esteja tentando inserir outro usuário pertença a outro grupo diferente
	*    de ROOT, então não é possível inserir o usuário neste grupo ROOT. Apenas outros usuários
	*    do grupo ROOT podem inserir.
	* @return void
	*/
	public function insert()
	{
		// Valida a permissão
		$this->validate_permission('INSERT');
		
		// Coleta grupos para fazer validação posterior
		$this->load->model('acme_user_group_model');
		$args['groups'] = $this->acme_user_group_model->get_user_groups();
		
		// Variável de teste se usuário atual é ROOT
		$args['is_root'] = ($this->session->userdata('user_group') == 'ROOT') ? true : false;
		
		// Carrega view
		$this->template->load_page('_acme/app_user/form_insert_custom', $args);
	}
	
	/**
	* form_insert_custom_process()
	* Processa formulário customizado de inserção de usuário.
	* @return void
	*/
	public function form_insert_custom_process()
	{
		// Valida a permissão
		$this->validate_permission('INSERT');
		
		// Inicializa transação
		$this->db->trans_start();
		
		// Insere usuário (acm_user)
		$arr_ins['id_user_group'] = $this->input->post('id_user_group');
		$arr_ins['name'] = $this->input->post('name');
		$arr_ins['email'] = $this->input->post('email');
		$arr_ins['login'] = $this->input->post('login');
		$arr_ins['password'] = md5($this->input->post('password'));
		$arr_ins['observation'] = $this->input->post('observation');
		$this->db->insert('acm_user', $arr_ins);

		// Retorna o último ID de usuário com base no que foi inserido
		$user = $this->db->get_where('acm_user', array('login' => $arr_ins['login']))->result_array();
		$user = isset($user[0]) ? $user[0] : array();
		$id_user = get_value($user, 'id_user');
		
		// Insere na tabela de configurações
		$arr_con['id_user'] = $id_user;
		$arr_con['lang_default'] = $this->input->post('lang_default');
		$arr_con['url_default'] = $this->input->post('url_default');
		$this->db->insert('acm_user_config', $arr_con);
		
		// Loga inserção de usuário
		$this->log->db_log(lang('Inserção de usuário'), 'insert', 'acm_user', array_merge($arr_ins, $arr_con));
		
		// Completa transação
		$this->db->trans_complete();
		
		// Redirect para entrada do módulo
		redirect('acme_user');
	}
	
	/**
	* form_update_custom()
	* Formulário customizado de inserção de usuário. Regras básicas:
	* -> Caso o usuário atual não seja do grupo ROOT, então não poderá editar os dados de usuários
	*    do grupo ROOT.
	* @param int id_user
	* @return void
	*/
	public function form_update_custom($id_user = 0)
	{
		// Valida a permissão
		$this->validate_permission('UPDATE');
		
		// Coleta dados do usuário de id encaminhado
		$args['user'] = $this->app_user_model->get_user_data($id_user);
		
		// Coleta grupos para fazer validação posterior
		$this->load->model('acme_user_group_model');
		$args['groups'] = $this->acme_user_group_model->get_user_groups();
		
		// Variável de teste se usuário atual é ROOT
		$args['is_root'] = ($this->session->userdata('user_group') == 'ROOT') ? true : false;
		
		// Variável para teste de edição
		$args['editable'] = ($this->session->userdata('user_group') != 'ROOT' && get_value($args['user'], 'group_name') == 'ROOT') ? false : true;
		
		// Carrega view
		$this->template->load_page('_acme/app_user/form_update_custom', $args);
	}
	
	/**
	* form_update_custom_process()
	* Processa formulário customizado de edição de usuário.
	* @return void
	*/
	public function form_update_custom_process()
	{
		// Valida a permissão
		$this->validate_permission('UPDATE');
		
		// Inicializa transação
		$this->db->trans_start();
		
		// Coleta os dados do usuário para log
		$id_user = $this->input->post('id_user');
		$user = $this->app_user_model->get_user_data($id_user);
		
		// Insere usuário (acm_user)
		if($this->input->post('login') != '')
		{
			$arr_ins['login'] = $this->input->post('login');
		}
		if($this->input->post('dtt_inative') != '')
		{
			$this->db->set('dtt_inative', $this->input->post('dtt_inative'), false);
		} else {
			$this->db->set('dtt_inative', 'NULL', false);
		}
		$arr_ins['id_user_group'] = $this->input->post('id_user_group');
		$arr_ins['name'] = $this->input->post('name');
		$arr_ins['email'] = $this->input->post('email');
		$arr_ins['observation'] = $this->input->post('observation');
		$this->db->update('acm_user', $arr_ins, array('id_user' => $id_user));
		
		// Coleta os dados de configs do usuário para log
		$configs = $this->app_user_model->get_user_data($id_user);
		
		// Insere na tabela de configurações
		$arr_con['id_user'] = $id_user;
		$arr_con['lang_default'] = $this->input->post('lang_default');
		$arr_con['url_default'] = $this->input->post('url_default');
		$this->db->update('acm_user_config', $arr_con, array('id_user' => $id_user));
		
		// Loga edição de usuário
		$this->log->db_log(lang('Edição de usuário'), 'update', 'acm_user', array(array_merge($user, $configs), array_merge($arr_ins, $arr_con)));
		
		// Completa transação
		$this->db->trans_complete();
		
		// Redirect para entrada do módulo
		redirect('acme_user');
	}
	
	/**
	* verify_login()
	* Verifica se um login de id encaminhado existe ou não e retorna um booleano em JSON.
	* @param string login
	* @return void
	*/
	public function verify_login($login = '')
	{
		$data = $this->db->get_where('acm_user', array('login' => $login));
		$user = $data->result_array();
		$user = isset($user[0]) ? $user[0] : array();
		$ret['user_exists'] = (get_value($user, 'id_user') != '') ? true : false;
		echo json_encode($ret);
	}
	
	/**
	* reset_password()
	* Tela de confirmação de solicitação de reset de senha.
	* @param int id_user
	* @return void
	*/
	public function reset_password($id_user = 0)
	{
		$this->validate_permission('RESET_PASSWORD');
		
		// Coleta dados do usuário
		$args['user'] = $this->app_user_model->get_user_data($id_user);
		
		// Carrega view
		$this->template->load_page('_acme/app_user/reset_password', $args);
	}
	
	/**
	* reset_password_process()
	* Processa tela de confirmação de solicitação de reset de senha. Faz o envio realmente de email
	* para o usuário.
	* @return void
	*/
	public function reset_password_process()
	{
		$this->validate_permission('RESET_PASSWORD');
		
		// Coleta dados do usuário
		$user = $this->app_user_model->get_user_data($this->input->post('id_user'));
		
		// Tenta enviar email para usuário
		// caso falhe, nao faz insert na tabela de log de resets
		$args['user'] = $user;
		$args['key_access'] = md5(uniqid());
		$message_body = $this->template->load_page('_acme/app_user/email_body_message_reset_password', $args, true, false);
		
		// Faz o envio, definitivamente
		if($this->app_email->send_email(lang('Solicitação de Alteração de Senha'), $message_body, get_value($user, 'email')))
		{
			// Seta controle OK
			$args['sent_email'] = true;
			
			// Gera chave de acesso para reset de senha
			$arr_ins['id_user'] = get_value($user, 'id_user');
			$arr_ins['email'] = get_value($user, 'email');
			$arr_ins['key_access'] = $args['key_access'];
			$this->db->insert('acm_user_reset_password', $arr_ins);
			
			// Loga reenvio de senha
			$this->log->db_log(lang('Solicitação de Alteração de Senha'), 'reset_password', 'acm_user_reset_password', $user);
		} else {
			$args['sent_email'] = false;
		}
		
		// Carrega view
		$this->template->load_page('_acme/app_user/reset_password_process', $args);
	}
	
	/**
	* ajax_copy_permissions()
	* Modal de cópia de permissões de um determinado usuário para o usuário de id encaminhado.
	* @param integer id_user
	* @return void
	*/
	public function ajax_copy_permissions($id_user = 0)
	{
		// Valida permissão
		$args['permission'] = $this->validate_permission('COPY_PERMISSIONS', false);
		
		// Dados do usuário
		$args['user'] = $this->app_user_model->get_user_data($id_user);
		
		// Dados de opções de usuário
		$args['user_options'] = $this->form->build_array_html_options($this->app_user_model->get_users_to_html_options());
		
		// Variável para teste de caso usuario nao seja root e esteja tentando acessar uma copia para um
		$args['editable'] = ($this->session->userdata('user_group') != 'ROOT' && get_value($args['user'], 'group_name') == 'ROOT') ? false : true;
		
		// Carrega view
		$this->template->load_page('_acme/app_user/ajax_copy_permissions', $args, false, false);
	}
	
	/**
	* ajax_copy_permissions_process()
	* Processa modal de cópia de permissões de um determinado usuário para outro, ambos de id
	* encaminhado por post.
	* @return void
	*/
	public function ajax_copy_permissions_process()
	{
		$id_user_to = $this->input->post('id_user_to');
		$id_user_from = $this->input->post('id_user_from');
		if($this->validate_permission('COPY_PERMISSIONS', false) && $id_user_from != '' && $id_user_to != '')
		{
			// Deleta permissões anteriores do usuário PARA
			$this->db->where(array('id_user' => $id_user_to));
			$this->db->delete('acm_user_permission');
			
			// Copia permissões
			$this->app_user_model->copy_permissions($id_user_from, $id_user_to);
			
			// Carrega view
			$this->template->load_page('_acme/app_user/ajax_copy_permissions_process', array(), false, false);
		}		
	}
}
