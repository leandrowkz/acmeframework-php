<?php
/**
*
* logo_area()
*
* Retorna a área de logo da aplicação.
*
* @param string link_url
* @return string html
*/
function logo_area ($url = '')
{
	if( ! file_exists(URL_IMG . '/logo.png'))
		return '<div class="navbar-brand"><a href="' . $url . '">' . APP_NAME . '</a></div>';
	else
        return '<div class="navbar-brand"><a href="' . $url . '"><img src="' . URL_IMG . '/logo.png" /></a></div>';
}