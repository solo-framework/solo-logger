<?php
/**
 *
 *
 * PHP version 5
 *
 * @package
 * @author  Andrey Filippov <afi.work@gmail.com>
 */

use Solo\Logger\Logger;

require_once "../vendor/autoload.php";


$settings = [

	// This is a list of loggers
	"loggers" => [

		// this is a name of logger. You can get the logger by name calling Logger::get("logger_name")
		"test-logger" => [
			"writers" => ["default"],
			"format" => "{date-time} {log-name} [{log-level}]: {log-message}\nContext: {log-context}\n\n"
		]
	],
];

Logger::init($settings);

// write to default logger
Logger::get()->debug("Some message");

// write to custom logger
Logger::get("test-logger")->debug("Test message");
