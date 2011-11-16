<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @section LICENSE
 * This code does not bear any licenses or complexities as such,
 * and should be treated same as works in the public domain.
 * 
 * @author Milad Bashiri
 * @version 0.1
 */

class Logger
{
	/* configuration parameters */
	var $enabled = TRUE;
	var $debug = TRUE; ///< option to record log messages marked as DEBUG
	var $path = 'logs/'; ///< path relative to codeigniter APPPATH
	/**
	 * @brief maximum size of the log file, in bytes.
	 * 
	 * Maximum size of the log file, in bytes. If log exceeds this size, the
	 * current log file is archived, and a new one is created.\n
	 * Set -1 for unlimited size (not recommended).\n
	 * Note: The log files are expected to exceed this size by some hundred
	 * bytes (size of one or two log records) based on current
	 * implementation.
	 */
	var $max_file_size = 512000;
	var $file_name = 'current';
	var $archive_prefix = 'log_'; ///< prefix for archived log files
	/* global info, common for each instance */
	var $user_id = '""';
	var $module_name = '""';
	/* end of configuration parameters */
	
	public function __construct ($config = array())
	{
		foreach (array('enabled', 'debug', 'path', 'max_file_size', 'user_id',
		               'module_name', 'file_name',
		               'archive_prefix') as $key) {
			if (isset($config[$key])) {
				$this->$key = $config[$key];
			}
		}
		
	}
	
	/**
	 * @brief Log a string in the server
	 * 
	 * Logs a string in the server using the parameters specified.
	 * This function serves as the main interface of the class, although
	 * the real work is done in the private function do_log, and this
	 * function only validates and prepares the parameters needed for that
	 * function.
	 * $log_string, $unique_id, and $timestamp are optional.
	 * 
	 * @author Milad Bashiri
	 * @param $level specifies the security level of the event. permitted
	 * values for $level are: INFO, WARN, THREAT, ERROR, and DEBUG.
	 * @param $action a short string to identify and categorize similar
	 * events
	 * @param $log_string the long description of the event to log
	 * @param $unique_id a unique string to identify the event. if left
	 * empty, it is automatically generated using the internal rand_gen
	 * function.
	 * @param $timestamp time of the event occurance. if left empty, the
	 * current system time is used.
	 * @throws Exception if the provided value for $level does not match one
	 * one of the permitted levels, an exception is raised.
	 * @see do_log()
	 */
	public function log ($level, $action, $log_string = '',
	                     $unique_id = NULL, $timestamp = NULL)
	{
		if ($this->enabled === FALSE) {
			return;
		}
		
		if (!in_array($level, array('INFO', 'WARN', 'THREAT', 'ERROR',
		                            'DEBUG'))) {
			throw new Exception("Logger Exception: Allowed Levels are 'INFO'," .
			                    " 'WARN', 'THREAT', 'ERROR', and 'DEBUG'.");
		}
		
		if ($level == "DEBUG" && $this->debug === FALSE) {
			return;
		}
		
		if ($timestamp === NULL) {
			$timestamp = microtime(true);
		}
		
		if ($unique_id === NULL) {
			$unique_id = rand_gen(8);
		}
		
		$this->do_log($timestamp, $unique_id, $this->user_id, $level,
		              $this->module_name, $action, $log_string);
	}
	
	/**
	 * @brief Internal function responsible for writing the log.
	 * 
	 * Internal function that logs the given string unconditinally,
	 * without checking validity of the parameters. Calling public function
	 * 'log' is preferred. Use with caution.
	 * 
	 * @author Milad Bashiri
	 * @param $timestamp time of the event occurance.
	 * @param $unique_id a unique string to identify the event
	 * @param $user_id id of the user responsible for the event
	 * @param $level specify the security level of the event
	 * @param $module_name name of the module responsible for the event
	 * @param $action a short string to identify and categorize similar
	 * events
	 * @param $log_string the long description of the event to log
	 * @throws Exception if the given directory is not found, an exception
	 * is raised.
	 * @see log()
	 */
	private function do_log ($timestamp, $unique_id, $user_id, $level,
	                         $module_name, $action, $log_string)
	{
		$seconds = floor($timestamp);
		$millis = round(($timestamp - $seconds) * 1000);
		
		$timestamp_str = sprintf('%s.%03d', date("Y-m-d H:i:s"), $millis);
		$escaped_log_string = str_replace('"', '\\"', $log_string);
		$log_str = sprintf('"%s",%s,%s,%s,%s,%s,"%s"', $timestamp_str,
		                   $unique_id, $user_id, $level, $module_name,
		                   $action, $escaped_log_string);
		$dir_name = APPPATH . $this->path;
		clearstatcache();
		if (!is_dir($dir_name)) {
			throw new Exception('Logger Exception: Directory \'' . $dir_name . 
			                    '\' does not exist.');
		}
		$full_name = $dir_name . $this->file_name . '.txt';
		if (is_file($full_name)) {
			$file_size = filesize($full_name);
			if ($this->max_file_size > 0 &&
			    $file_size >= $this->max_file_size) {
				$fcsv = fopen($full_name, 'r');
				fgetcsv($fcsv, 256); //skip over header
				$first = fgetcsv($fcsv, 256);
				fclose($fcsv);
				$start_date = $first[0];
				rename($this->file_name, $this->archive_prefix . $start_date .
				       '.txt');
				$this->create_new_log($full_name);
			}
		} else {
			$this->create_new_log($full_name);
		}
		$fp = fopen($full_name, 'a');
		fwrite($fp, $log_str . "\n");
		fclose($fp);
	}
	private function create_new_log($full_name)
	{
		$header_str = 'timestamp,unique_id,user_id,level,module_name,' .
		              'action,log_string';
		$fp = fopen($full_name, 'w');
		fwrite($fp, $header_str . "\n");
		fclose($fp);
	}
}

/* End of file Logger.php */