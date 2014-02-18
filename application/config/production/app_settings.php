<?php
/*
* -------------------------------------------------------------------
*  ARQUIVO DE CONFIGURAÇÕES DA APLICAÇÃO
* -------------------------------------------------------------------
*
* Este arquivo concentra configurações diversas da aplicação. Para cada
* índice do array de configurações uma constante de mesmo nome será criada
* e estará disponível globalmente  As configurações abaixo referem ao ambiente da aplicação e da própria 
* aplicação] = em geral. Define qual ambiente atual da aplicação e se está
* em manutenção ou não. Também define o template que está sendo utilizado
* atualmente e o título padrão utilizado para páginas HTML] = no sistema.
*/


/*
* -------------------------------------------------------------------
*  CONFIGURAÇÕES DE AMBIENTE E APLICAÇÃO
* -------------------------------------------------------------------
*
* As configurações abaixo referem ao ambiente da aplicação e da própria 
* aplicação] = em geral. Define qual ambiente atual da aplicação e se está
* em manutenção ou não. Também define o template que está sendo utilizado
* atualmente e o título padrão utilizado para páginas HTML] = no sistema.
*/
$config['ENVIRONMENT'] = 'development';
$config['IS_MAINTAINING'] = false;
$config['APP_NAME'] = 'TAPMANAGER';
$config['TEMPLATE'] = 'bootstrap-flatly';
$config['APP_TITLE'] = 'TAP Manager - Gerenciador de Projetos e Tarefas';
$config['DEFAULT_LANGUAGE'] = 'pt_BR';


/*
* -------------------------------------------------------------------
*  CONFIGURAÇÕES DE BANCO DE DADOS
* -------------------------------------------------------------------
*
* Configurações referentes ao banco de dados atual. Define o host] = porta,
* banco padrão] = usuário e senha. Atualmente] = suporte apenas para MySQL.
*/
$config['DB_DRIVER'] = 'oci8';
$config['DB_HOST'] = 'localhost';
$config['DB_PORT'] = '3306';
$config['DB_USER'] = 'root';
$config['DB_PASS'] = 'mysql';
$config['DB_DATABASE'] = 'tapmanager';


/*
* -------------------------------------------------------------------
*  CONFIGURAÇÕES DE EMAIL
* -------------------------------------------------------------------
*
* Configurações gerais referentes ao envio de emails na aplicação (servidores, 
* portas, caracteres e métodos padrão).
*/
$config['EMAIL_PROTOCOL'] = 'smtp';
$config['EMAIL_SMTP_HOST'] = 'ssl://smtp.googlemail.com';
$config['EMAIL_SMTP_PORT'] = '465';
$config['EMAIL_SMTP_TIMEOUT'] = '30';
$config['EMAIL_SMTP_USER'] = 'tapmanager.cc@gmail.com';
$config['EMAIL_SMTP_PASS'] = 'web69complex@tapmanager';
$config['EMAIL_CHAR_NEWLINE'] = "\r\n";
$config['EMAIL_CHAR_CRLF'] = "\r\n";
$config['EMAIL_MAILTYPE'] = "html";
$config['EMAIL_CHARSET'] = "utf-8";
$config['EMAIL_GLOBAL_NAME_FROM'] = "TAP Manager";
$config['EMAIL_GLOBAL_ADDRESS_FROM'] = "noreply@tapmanager.com.br";


/*
* -------------------------------------------------------------------
*  CONFIGURAÇÕES DE URLS e PATHS
* -------------------------------------------------------------------
*
* Configurações referentes as urls e paths utilizados no sistema. Por 
* padrão não é necessário alterar estas configurações - apenas caso a
* estrutura do sistema que está sendo construído seja modificada.
*/
if(function_exists('base_url'))
{
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
	$config['PATH_HTML_COMPONENTS'] = $config['TEMPLATE'] . '/_includes/html_components';
}


/*
* ------------------------
*  AUTOLOAD DE SCRIPTS JS
* ------------------------
* Os arquivos localizados no array abaixo serão automaticamente carregados em uma página qualquer 
* de visualização do template, quando dentro da seção <head></head> do documento html for invocado
* o método da biblioteca template:
* echo $this->template->load_array_config_js_files();
* Este método faz com que os scripts abaixo fiquem disponíveis através das tags <script src...>
* </script>
*/
$config['JS_FILES'] = array(
							'functions.global.js', 
							'functions.needed.js', 
							'jquery.min.1.7.2.js', 
							'jquery.layout.js', 
							'jquery.meiomask.js', 
							'jquery.simplemodal.js', 
							'jquery.tablesorter.js',
							'canvasloader.0.9.1/canvasloader.min.0.9.1.js', 
							'jquery.validationengine.js', 
							'jquery.validationengine.' . $config['DEFAULT_LANGUAGE'] . '.js',
							'bootstrap.js'
							);
							
							
/*
* --------------------------
*  AUTOLOAD DE ARQUIVOS CSS
* --------------------------
* Os arquivos localizados no array abaixo serão automaticamente carregados em uma página qualquer 
* de visualização do template, quando dentro da seção <head></head> do documento html for invocado
* o método da biblioteca template:
* echo $this->template->load_array_config_css_files();
* Este método faz com que os arquivos abaixo fiquem disponíveis através das tags <link href... />
*/
$config['CSS_FILES'] = array(
							'style.css', 
							'jquery.layout.css',
							'bootstrap.css'
							);