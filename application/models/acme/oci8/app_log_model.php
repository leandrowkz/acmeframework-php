<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* --------------------------------------------------------------------------------------------------
*
* Model App_Log_Model
*
* Database layer for the controller app_log.
* 
* @since    03/11/2012
*
* --------------------------------------------------------------------------------------------------
*/
class App_Log_Model extends CI_Model {
    
    /**
    * __construct()
    * Class constructor.
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
                 \'activity\' AS log_type,
                 l.id_log,
                 l.table_name,
                 l.action,
                 l.log_description,
                 l.log_description AS message,
                 l.additional_data,
                 l.user_agent,
                 l.browser_name,
                 l.browser_version,
                 l.device_name,
                 l.device_version,
                 l.platform,
                 l.ip_address,
                 l.log_dtt_ins,
                 u.email
            FROM acm_log  l
       LEFT JOIN acm_user u ON (u.id_user = l.id_user)
        
       UNION ALL

          SELECT
                 \'error\' AS log_type,
                 l.id_log_error,
                 \'\',
                 l.error_type,
                 CONCAT(CONCAT(CONCAT(l.header, \' - \'), SUBSTR(l.message, 0, 30)), \'...\'),
                 l.message,
                 l.additional_data,
                 l.user_agent,
                 l.browser_name,
                 l.browser_version,
                 l.device_name,
                 l.device_version,
                 l.platform,
                 l.ip_address,
                 l.log_dtt_ins,
                 u.email
            FROM acm_log_error  l
       LEFT JOIN acm_user       u ON (u.id_user = l.id_user)

        ) logs WHERE ROWNUM <= 1000 ORDER BY logs.log_dtt_ins DESC';
        
        return $this->db->query($sql)->result_array();
    }
 
}
