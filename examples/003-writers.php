<?php
/**
 *
 *
 * PHP version 5
 *
 * @package
 * @author  Andrey Filippov <afi.work@gmail.com>
 */

use Solo\Logger\Level;
use Solo\Logger\Logger;

require_once "../vendor/autoload.php";


$settings = [
	"loggers" => [
		"test-logger" => [
			// Add your writers into logger
			"writers" => ["default", "file-writer", "error-file-writer"],
			"format" => "{date-time} {log-name} [{log-level}]: {log-message}\nContext: {log-context}\n\n"
		]
	],

	// list of writers
	"writers" => [

		// Here we defined a new writer
		"file-writer" => [
			"level" => Level::DEBUG,
			"class" => "Solo\\Logger\\Writers\\FileWriter",
			"options" => [
				"output" => "003-common-log.txt"
			]
		],

		// writes messages with ERROR level only
		"error-file-writer" => [
			"level" => Level::ERROR,
			"class" => "Solo\\Logger\\Writers\\FileWriter",
			"writeOnlyCurrentLevel" => true, // if true, this writer will handle messages with the current level only
			"options" => [
				"output" => "003-error-log.txt"
			]
		],
	]
];

Logger::init($settings);

// write to default logger
Logger::get()->debug("Some message");

// write to custom logger
$object = new DateTime();
Logger::get("test-logger")->debug("There is an object", $object);
Logger::get("test-logger")->error("There is an error", $object);
Logger::get("test-logger")->alert("There is an alert", $object);

// In this example