<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* --------------------------------------------------------------------------------------------------
*
* Model App_Log_Model
*
* Camada model do modulo app_log.
* 
* @since 	03/11/2012
*
* --------------------------------------------------------------------------------------------------
*/
class App_Log_Model extends CI_Model {
	
	/**
	* __construct()
	* Construtor de classe.
	* @return object
	*/
	public function __construct()
	{
		parent::__construct();
	}

	/**
	* get_all_logs()
	* Return all application logs (logs + errors).
	* @return array data
	*/
	public function get_all_logs()
	{
		$sql = '
		SELECT * FROM (

		  SELECT
   				 \'activity\' AS LOG_TYPE,
   				 L.ID_LOG,
   				 L.TABLE_NAME,
   				 L.ACTION,
   				 L.LOG_DESCRIPTION,
   				 L.LOG_DESCRIPTION AS MESSAGE,
   				 L.ADDITIONAL_DATA,
   				 L.USER_AGENT,
   				 L.BROWSER_NAME,
   				 L.BROWSER_VERSION,
   				 L.DEVICE_NAME,
   				 L.DEVICE_VERSION,
   				 L.PLATFORM,
   				 L.IP_ADDRESS,
   				 L.LOG_DTT_INS,
   				 U.EMAIL
 	   	   	FROM ACM_LOG  L
 	   LEFT JOIN ACM_USER U ON (U.ID_USER = L.ID_USER)
		
       UNION ALL

       	  SELECT
   				 \'error\' AS LOG_TYPE,
   				 L.ID_LOG_ERROR,
   				 \'\',
   				 L.ERROR_TYPE,
   				 CONCAT(CONCAT(CONCAT(L.HEADER, \' - \'), SUBSTR(L.MESSAGE, 0, 30)), \'...\'),
   				 L.MESSAGE,
   				 L.ADDITIONAL_DATA,
   				 L.USER_AGENT,
   				 L.BROWSER_NAME,
   				 L.BROWSER_VERSION,
   				 L.DEVICE_NAME,
   				 L.DEVICE_VERSION,
   				 L.PLATFORM,
   				 L.IP_ADDRESS,
   				 L.LOG_DTT_INS,
   				 U.EMAIL
 	   	   	FROM ACM_LOG_ERROR  L
 	   LEFT JOIN ACM_USER       U ON (U.ID_USER = L.ID_USER)

 	   	) LOGS WHERE ROWNUM <= 1000 ORDER BY LOGS.LOG_DTT_INS DESC';
		
		return $this->db->query($sql)->result_array();
	}
 
}
