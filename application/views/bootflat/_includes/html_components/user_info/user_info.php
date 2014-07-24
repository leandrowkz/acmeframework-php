<?php
/**
*
* user_info()
*
* This function build a html block with user information (like username, image, etc).
*
* @param string id_user
* @param string login
* @param string email
* @param string username
* @param string usergroup
* @param string url_img
* @return string user_info
*
*/
function user_info($id_user = 0, $login = '', $email = '', $username = '', $usergroup = '', $url_img = '')
{
	$CI =& get_instance();
	
	// User first name
	$first_name = get_value(explode(' ', $username), '0');

	// Image adjustment (in case that image doesnt exist)
	$url_img = ( ! file_exists(PATH_UPLOAD . '/user_photos/' . basename($url_img)) || basename($url_img) == '') ? URL_IMG . '/user-unknown.png' : $url_img;

	// User information dropdown
	$html  = '	<li class="dropdown">';
	$html .= '	<a class="dropdown-toggle" data-toggle="dropdown" href="#">
              		<img src="' . $url_img . '" class="img-circle user-photo" />
                    <span class="user-info">
                        <small>' . lang('Welcome') . '</small>
                        <br />' . $first_name . '
                    </span>
                    <i class="fa fa-caret-down"></i>
                </a>
                <ul class="dropdown-menu dropdown-user">
                    <li><a href="' . URL_ROOT . '/app_user/profile/' . $id_user . '"><i class="fa fa-user fa-fw"></i> ' . lang('Profile') . '</a></li>
                    <li>
                        <a class="container-html cursor-pointer">
                            <i class="fa fa-fw fa-square text-danger"></i> ' . lang('HTML Container') . '
                        </a>
                    </li>
                    <li class="divider"></li>
                    <li>
                    	<a href="javascript:void(0)" onclick="ajax_change_language(\'en_US\')">
                    	<i class="fa fa-check fa-fw ' . (($CI->session->userdata('language') != 'en_US') ? 'icon-invisible' : '' ) . '"></i> ' . lang('English') . '</a>
                    </li>
                    <li>
                    	<a href="javascript:void(0)" onclick="ajax_change_language(\'pt_BR\')">
                    	<i class="fa fa-check fa-fw ' . (($CI->session->userdata('language') != 'pt_BR') ? 'icon-invisible' : '' ) . '"></i> ' . lang('Brazilian Portuguese') . '</a>
                    </li>
                    <li class="divider"></li>
                    <li><a href="http://www.acmeengine.org" target="_blank"><i class="fa fa-question-circle fa-fw"></i> ' . lang ('Help') . '</a></li>
                    <li><a href="' . URL_ROOT . '/app_access/logout"><i class="fa fa-sign-out fa-fw"></i> ' . lang ('Logout') . '</a></li>
                </ul>
                </li>';

    // script for some clicks
    $html .= "
    <script>
        
        $('.container-html').on('click', function(e) {

            // prevent clicking
            e.preventDefault();

            // toggle container
            $.container_html();

            // Build a pretty checkbox
            $(this).find('i').toggleClass('fa-check-square fa-square');

            return false;
        });

        
        // HTML container check
        $(document).ready( function () {

            if($.read_cookie('container-html') != null)
                $('.container-html').click();
        });
    
    </script>";
	
	return $html;
}