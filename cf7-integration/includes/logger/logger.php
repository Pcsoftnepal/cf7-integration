<?php
/** 
 * Class for logging CF7 integration activities
 *
 * @package    CF7_Integration
 * @subpackage CF7_Integration/includes
 * @author     Your Company <email@example.com>
 */

if (!defined('WPINC')) {
    die;
}

/**
 * Class CF7_Logger
 */
class CF7_Logger {
    
    /**
     * Log file name
     */
    const LOG_FILE = 'cf7-integration.log';

    /**
     * Initialize the class and set its properties
     */
    public function __construct() {
        // Constructor logic here
    }

    /**
     * Log an error message
     *
     * @param string $message
     * @param string $level
     * @return void
     */
    public function log_error($message, $level = 'ERROR') {
        $this->write_log($message, $level);
    }

    /**
     * Log an info message
     *
     * @param string $message
     * @param string $level
     * @return void
     */
    public function log_info($message, $level = 'INFO') {
        $this->write_log($message, $level);
    }

    /**
     * Write a message to the log file
     *
     * @param string $message
     * @param string $level
     * @return void
     */
    private function write_log($message, $level = 'INFO') {
        // Check if logging is enabled in settings
        if (!CF7_Settings::is_logging_enabled()) {
            return;
        }

        $log_file = WP_CONTENT_DIR . '/uploads/' . self::LOG_FILE;
        
        // Ensure upload directory exists
        $upload_dir = wp_upload_dir();
        $log_file = $upload_dir['basedir'] . '/' . self::LOG_FILE;
        
        $timestamp = date('Y-m-d H:i:s');
        $log_entry = "[{$timestamp}] {$level}: {$message}" . PHP_EOL;
        
        // Write to log file
        error_log($log_entry, 3, $log_file);
    }

    /**
     * Get the log file path
     *
     * @return string
     */
    public static function get_log_file_path() {
        $upload_dir = wp_upload_dir();
        return $upload_dir['basedir'] . '/' . self::LOG_FILE;
    }

    /**
     * Read log entries
     *
     * @param int $limit
     * @return array
     */
    public function read_logs($limit = 100) {
        $log_file = self::get_log_file_path();
        
        if (!file_exists($log_file)) {
            return array();
        }
        
        $logs = file($log_file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        return array_slice($logs, -$limit);
    }
    
    /**
     * Clear the log file
     *
     * @return void
     */
    public function clear_logs() {
        $log_file = self::get_log_file_path();
        if (file_exists($log_file)) {
            file_put_contents($log_file, '');
        }
    }
}