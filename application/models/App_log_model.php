<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * --------------------------------------------------------------------------------------------------
 * Model App_log_model
 *
 * Database layer for the controller app_log.
 *
 * @since    03/11/2012
 * --------------------------------------------------------------------------------------------------
 */
class App_log_model extends CI_Model {

    /**
     * Class constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Return all application logs (logs + errors).
     *
     * @return array data
     */
    public function get_all_logs()
    {
        // Build query according with driver
        switch(strtolower(DB_DRIVER))
        {
            case 'mysql':
            case 'mysqli':
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

                ) logs ORDER BY logs.log_dtt_ins DESC LIMIT 0, 1000';
            break;

            case 'postgre':
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

                ) logs ORDER BY logs.log_dtt_ins DESC LIMIT 1000 OFFSET 0';
            break;

            // Oracle driver
            case 'oci8':
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
            break;
        }

        // Return query
        return $this->db->query($sql)->result_array();
    }
}
