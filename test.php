<?php
/**
 *
 *
 * PHP version 5
 *
 * @package
 * @author  Andrey Filippov <afi@i-loto.ru>
 */

use Solo\Logger\Level;
use Solo\Logger\Logger;

require_once "vendor/autoload.php";

$settings = [
	"loggers" => [
		"default" => [
			"writers" => ["default", "http"],
			"format" => "{date-time} [{log-level}] {logger-name} [IP: {ip-address}]:\nMessage:\n{message}\n"
		]
	],

	"writers" => [
		"http" => [
			"level" => Level::DEBUG,
			"class" => "Solo\\Logger\\Writers\\HttpWriter",
			"writeOnlyCurrentLevel" => false,
			"ignoreErrors" => false,
			"options" => [ "url" => "http://local-box.ru" ]
		],

		"file_debug" => [
			"level" => Level::DEBUG,
			"class" => "Solo\\Logger\\Writers\\FileWriter",
			"writeOnlyCurrentLevel" => true,
			"ignoreErrors" => false,
			"options" => [
				"output" => "debug-log.txt"
			]
		],
		"file_error" => [
			"level" => Level::ERROR,
			"class" => "Solo\\Logger\\Writers\\FileWriter",
			"ignoreErrors" => false,
			"writeOnlyCurrentLevel" => true,
			"options" => [
				"output" => "error-log.txt"
			]
		],
	],

	"parsers" => [
//		"memory" => "Solo\\Logger\\Parsers\\MemoryUsageParser"
	]
];

Logger::init($settings);
$l = Logger::get();

$e = new RuntimeException("sfsdfsdfs");

$arr = array("2e2e" => "dssdsd", "000" => 928);

$obj = new stdClass();
$obj->mmmmm = "dsdsdsd";

//$l->error($arr);
//$l->debug($obj);
$l->error("dsdsd");
//print_r($l);



//$settings = [
//		"loggers" => [
//				"default" => [
////				"enabled" => false,
//						"writers" => ["js-console", "http"],
////				"format" => "{date-time} [{log-level}] {logger-name} [IP: {ip-address}]:\nMessage:\n{message}\n"
//				]
//		],
//
//		"writers" => [
//				"http" => [
//						"level" => Level::DEBUG,
//						"class" => "Solo\\Logger\\Writers\\HttpWriter",
//						"writeOnlyCurrentLevel" => false,
//						"ignoreErrors" => false,
//						"options" => [ "url" => "http://localhost:8888" ]
//				],
//
//
//				"js-console" => [
//						"level" => Level::DEBUG,
//						"class" => "Solo\\Logger\\Writers\\JavascriptConsoleWriter",
//						"writeOnlyCurrentLevel" => false,
//						"ignoreErrors" => true,
//						"options" => [ ]
//				],
//
//				"file_debug" => [
//						"level" => Level::DEBUG,
//						"class" => "Solo\\Logger\\Writers\\FileWriter",
//						"writeOnlyCurrentLevel" => true,
//						"ignoreErrors" => false,
//						"options" => [
//								"output" => "debug-log.txt"
//						]
//				],
//				"file_error" => [
//						"level" => Level::ERROR,
//						"class" => "Solo\\Logger\\Writers\\FileWriter",
//						"ignoreErrors" => false,
//						"writeOnlyCurrentLevel" => true,
//						"options" => [
//								"output" => "error-log.txt"
//						]
//				],
//		],
//
//		"parsers" => [
//
//		]
//];
//
//Logger::init($settings);