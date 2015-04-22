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
// URLS
$config['URL_ROOT'] = rtrim(base_url(), '/');
$config['URL_UPLOAD'] = $config['URL_ROOT'] . '/application/uploads';
$config['URL_TEMPLATE'] = $config['URL_ROOT'] . '/application/views/' . $config['TEMPLATE'];
$config['URL_ASSETS'] = $config['URL_ROOT'] . '/assets';
$config['URL_CSS'] = $config['URL_ASSETS'] . '/css';
$config['URL_JS'] =  $config['URL_ASSETS'] . '/js';
$config['URL_IMG'] = $config['URL_ASSETS'] . '/img';

// PATHS
$config['PATH_TEMP'] = 'application/temp';
$config['PATH_UPLOAD'] = 'application/uploads';
$config['PATH_ASSETS'] = 'assets';
$config['PATH_CSS'] = $config['PATH_ASSETS'] . '/css';
$config['PATH_JS'] = $config['PATH_ASSETS'] . '/js';
$config['PATH_IMG'] = $config['PATH_ASSETS'] . '/img';
$config['PATH_HTML_COMPONENTS'] = 'application/views/' . $config['TEMPLATE'] . '/html-components';
