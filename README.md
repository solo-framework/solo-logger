# PHP Logger library

## Example

Here we use a default logger which writes messages into std output.

````
<?php

require_once "vendor/autoload.php";

Logger::init();
$logger = Logger::get();

$e = new RuntimeException("Error");
$arr = array("key" => "val", "key1" => 928);

$obj = new stdClass();
$obj->attribute = "value";

$l->error("Error!", $e);
$l->debug("Dump an array", $arr);
$l->debug("Write some object", $obj);
````

## Settings


````

Logger::init($settings);

````

The setting is array

````

$array = [
	"loggers" => [],
	"writers" => [],
	"parsers" => []
]

````

## Loggers

You can define several loggers.

````

"loggers" => [
	"test-logger" => [
	
		// enable\disable the logger.  Optional, default - true
		"enabled" => true,
		
		// list of writers. Required, default - ["default"]
		"writers" => ["default", "file-writer"],
		
		// format of log message. Required.
		"format" => "{date-time} {log-name} [{log-level}]: {log-message}\nContext: {log-context}\n\n"
	]
],

````

The **format** attribute contains macroses like {XXXX}. They will be replaced by values. 

**{date-time}** - currect date time
**{log-name}** - name of current logger
**{log-level}** - current log level 
**{log-message}** - log message
**{log-context}** - context object
**{ip-address}** - client IP address
**{env.}** - presents access to $GLOBALS array. For example, {env._SERVER.LC_NAME} will return value of $_SERVER["LC_NAME"]

## writers

Writer is an entity which writes log messages.

````

"writers" => [
	"file" => [
        "level" => Level::ERROR,
        "class" => "Solo\\Logger\\Writers\\FileWriter",
        "ignoreErrors" => false,
        "writeOnlyCurrentLevel" => true,
        "options" => [
            "output" => "error-log.txt"
        ]
    ],
]

````

**level** - writer will handle messages with this level and bigger. Required.
**class** - name of class. Required.
**ignoreErrors** - if true, ignore errors. Optional, default - true.
**writeOnlyCurrentLevel** - Write messages which correspond the current level only. Optional, default - false.
**options** - array with attributes and values of writer instance.