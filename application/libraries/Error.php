<?php
/**
 * --------------------------------------------------------------------------------------------------
 * Library Error
 *
 * Gathers methods related with the application error handling.
 *
 * @since 	01/10/2012
 * --------------------------------------------------------------------------------------------------
 */
class Error {

    /**
     * CI controller instance.
     * @var object
     */
	public $CI = null;

	/**
	 * Class constructor.
	 */
	public function __construct()
	{
		$this->CI =& get_instance();
	}

	/**
	 * Shows a generic error page according with the forwarded parameters.
	 *
	 * @param string header
	 * @param string message
	 * @param string template
	 * @param string status_code
	 * @param boolean log_error
	 * @return void
	 */
    public function show_error($header = '', $message = '', $template = 'error-general', $status_code = 500, $log_error = true)
    {
        // Adjust template
        $template = str_replace('_', '-', $template);

		// Log error on database
		if ($log_error)
			$this->CI->logger->log_error($template, $header, $message, $status_code);

		// Set properly error directory
        $dir = is_cli() ? 'cli' : 'html';

        // Load view
        echo $this->CI->template->load_view('errors/' . $dir .  '/' . $template, array('header' => $header, 'message' => $message), true, false);
		exit;
    }

    /**
     * Shows an exception page according with given Exception object.
     *
     * @param Exception $exception
     * @return void
     */
    public function show_exception(Exception $exception)
    {
        $this->CI =& get_instance();

        // Set properly error directory
        $dir = is_cli() ? 'cli' : 'html';

        // Load view
        echo $this->CI->template->load_view('errors/' . $dir . '/error-exception', array('exception' => $exception), true, false);
        exit;
    }

    /**
     * Shows a HTML box containing a PHP error. The page proccess is not interrupted.
     *
     * @param string severity
     * @param string message
     * @param string filepath
     * @param string line
     * @param boolean log_error
     * @return void
     */
	public function show_php_error($severity = '', $message = '', $filepath = '', $line = 0, $log_error = true)
	{
		// Resolve severity
		$severity = ( ! isset($this->levels[$severity])) ? $severity : $this->levels[$severity];

		// Log error on database
		if ($log_error)
			$this->CI->logger->log_error('error-php', lang('PHP Error'), $message . " (filepath: " . $filepath . ", line: " . $line . ")", 500);

        // Set properly error directory
        $dir = is_cli() ? 'cli' : 'html';

		// Load view box (process is not interrupted)
		echo $this->CI->template->load_view('errors/' . $dir . '/error-php', array('severity' => $severity, 'message' => $message, 'filepath' => $filepath, 'line' => $line), true, false);
	}

	/**
	 * Shows a 404 error page.
	 *
	 * @return void
	 */
	public function show_404()
	{
		$this->CI =& get_instance();

        // Set properly error directory
        $dir = is_cli() ? 'cli' : 'html';

        // Load view
		echo $this->CI->template->load_view('errors/' . $dir . '/error-404', array(), true, false);
		exit;
	}
}