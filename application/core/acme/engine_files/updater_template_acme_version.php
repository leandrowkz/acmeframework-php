<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
*
* Acme_Version
* 
* Classe estática responsável por armazenar informações a respeito da versão atual do ACME Engine. 
* Toda vez que uma atualização é rodada, a versão do sistema é alterada nesta classe. Em sua construção, 
* esta classe define a constante e atributo final ACME_VERSION, que retorna a versão corrente.
*
* @since		26/07/2013
* @location		acme.core.acme_version
*
*/
class Acme_Version {
	// Definição de atributos
	private static $ACME_VERSION = '<TEMPLATE_VERSION>';
	
	/**
	* build_define_version()
	* Cria constante de versão atual do sistema.
	* @return void
	*/
	public static function build_define_version()
	{
		define('ACME_VERSION', self::$ACME_VERSION);
	}
}
