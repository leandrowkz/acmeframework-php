<?php
/*
|--------------------------------------------------------------------------
| App settings
|--------------------------------------------------------------------------
|
| Configurações gerais da aplicação. Reúne informações como nome,
| template atual e idioma padrão. 
|
| Para cada índice do array $config deste arquivo uma constante será
| definida e estará disponível em nível global.
|
*/
$config['APP_NAME'] = 'TAPMANAGER';			// nome da aplicação
$config['TEMPLATE'] = 'bootstrap-flatly';	// template utilizado (dentro de /views)
$config['LANGUAGE'] = 'pt_BR';				// linguagem padrão

/*
|--------------------------------------------------------------------------
| URLs e PATHs
|--------------------------------------------------------------------------
|
| Definição de URLs e PATHs da aplicação. A URL raiz da aplicação é URL_ROOT.
|
| Para cada índice do array $config deste arquivo uma constante será
| definida e estará disponível em nível global.
|
*/
$config['URL_ROOT'] = rtrim(base_url(), '/');
$config['URL_UPLOAD'] = $config['URL_ROOT'] . '/application/uploads';
$config['URL_TEMPLATE'] = $config['URL_ROOT'] . '/application/views/' . $config['TEMPLATE'];
$config['URL_INCLUDE'] = $config['URL_TEMPLATE'] . '/_includes';
$config['URL_CSS'] = $config['URL_INCLUDE'] . '/css';
$config['URL_JS'] =  $config['URL_INCLUDE'] . '/js';
$config['URL_IMG'] = $config['URL_INCLUDE'] . '/img';

$config['PATH_TEMP'] = 'application/temp';
$config['PATH_UPLOAD'] = 'application/uploads';
$config['PATH_INCLUDE'] = 'application/views/' . $config['TEMPLATE'] . '/_includes';
$config['PATH_CSS'] = $config['PATH_INCLUDE'] . 'css';
$config['PATH_JS'] = $config['PATH_INCLUDE'] . 'js';
$config['PATH_IMG'] = $config['PATH_INCLUDE'] . 'img';
$config['PATH_HTML_COMPONENTS'] = $config['TEMPLATE'] . '/_includes/html_components';
