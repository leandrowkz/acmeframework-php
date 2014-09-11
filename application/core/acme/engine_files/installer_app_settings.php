<?php
/*
|--------------------------------------------------------------------------
| App settings
|--------------------------------------------------------------------------
|
| General application settings. Gather information like name, template and
| default language. 
|
| For each index from array $config a constant will be defined and will be 
| ready to use in a global level.
|
*/
$config['APP_NAME'] = 'ACME Framework';		// application name
$config['TEMPLATE'] = 'bootflat';			// current template (inside /views)
$config['LANGUAGE'] = 'en_US';				// default language
$config['EMAIL_FROM'] = 'noreply@app';		// to send emails

/*
|--------------------------------------------------------------------------
| URLs e PATHs
|--------------------------------------------------------------------------
|
| Application URLs and Paths. The application root URL is the constant URL_ROOT.
|
| For each index from array $config a constant will be defined and will be 
| ready to use in a global level.
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
$config['PATH_CSS'] = $config['PATH_INCLUDE'] . '/css';
$config['PATH_JS'] = $config['PATH_INCLUDE'] . '/js';
$config['PATH_IMG'] = $config['PATH_INCLUDE'] . '/img';
$config['PATH_HTML_COMPONENTS'] = $config['PATH_INCLUDE'] . '/html_components';
