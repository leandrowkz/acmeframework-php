<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * --------------------------------------------------------------------------------------------------
 * ACME_Router (extended from CI_Router)
 *
 * This class is used to map and handle with all application routes.
 *
 * @since	28/08/2015
 * --------------------------------------------------------------------------------------------------
 */
class ACME_Router extends CI_Router {

	/**
	 * This method allows ACME Framework application to use case-insensitive routes.
	 *
	 * @return string routes
	 */
	public function _parse_routes()
	{
	    foreach ($this->uri->segments as &$segment)
	        $segment = strtolower($segment);

	    return parent::_parse_routes();
	}
}
