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


//
//$fi = new SplFileInfo(realpath("log.txt"));
//
//$files = glob("{$fi->getRealPath()}.*");
//print_r($files);
//
//usort($files, function ($a, $b) {
//	return strcmp($b, $a);
//});
//
//var_dump($fi->getRealPath());
//var_dump($fi->getBasename());
//var_dump($fi->getFilename());
//var_dump($fi->getPathname());
//var_dump($fi->getPath());
////exit();
//$firstFile = realpath($files[0]);
//
//preg_match("%{$fi->getRealPath()}\.?([0-9]*)$%", $firstFile, $matches);
//
////print_r($firstFile);
//var_dump($matches);
//exit();

require_once "vendor/autoload.php";

$settings = [
	"loggers" => [
		"default" => [
			"writers" => ["file_debug"],
//			"format" => "{date-time} [{log-level}] {logger-name} [IP: {ip-address}]:\nMessage: {message}\nContext: {context}\n"
		]
	],

	"writers" => [
		"http" => [
			"level" => Level::DEBUG,
			"class" => "Solo\\Logger\\Writers\\HttpWriter",
			"writeOnlyCurrentLevel" => false,
			"ignoreErrors" => false,
			"options" => [ "url" => "http://localhost:8080" ]
		],

		"file_debug" => [
			"level" => Level::DEBUG,
			"class" => "Solo\\Logger\\Writers\\FileWriter",
			"writeOnlyCurrentLevel" => true,
			"ignoreErrors" => false,
			"options" => [
				"output" => "./{log-level}/debug-log.txt",
				"split" => true,
				"splitSize" => 100
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
for ($i =0; $i< 100000; $i++)
	$l->debug("Это сообщение", 122.22);



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