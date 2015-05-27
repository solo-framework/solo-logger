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
			"writers" => ["default", "file-writer"],

			// The {weather} string will be replaced with current weater data
			"format" => "{date-time} {log-name} [{log-level}]: {log-message}\nContext: {log-context}\nThe weather like:	{weather}\n\n"
		]
	],

	// list of writers
	"writers" => [

		// Here we defined a new writer
		"file-writer" => [
			"level" => Level::DEBUG,
			"class" => "Solo\\Logger\\Writers\\FileWriter",
			"options" => [
				"output" => "004-log-{log-level}.txt" // Here {log-level} will be replaced as logger level value
			]
		],
	],

	// List of parsers
	"parsers" => [
		"weather" => "WeatherParser"
	]
];


//
// Custom parser
//
class WeatherParser extends \Solo\Logger\Parsers\BaseParser
{
	/**
	 * Replace macros with useful data
	 *
	 * @return \Solo\Logger\LogRecord
	 */
	public function parse()
	{
		// get current weather, just for fun
		$data = file_get_contents("http://api.openweathermap.org/data/2.5/weather?zip=420000,ru&units=metric");
		$this->record->formatted = str_replace("{weather}", $data, $this->record->formatted);
		return $this->record;
	}
}

Logger::init($settings);
Logger::get("test-logger")->debug("There is an object");
Logger::get("test-logger")->error("There is another one");