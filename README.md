# PHP Logger library

## Example

Here we use a default logger which writes messages into std output.

````
<?php

require_once "vendor/autoload.php";

Logger::init($settings);
$logger = Logger::get();

$e = new RuntimeException("Error");
$arr = array("key" => "val", "key1" => 928);

$obj = new stdClass();
$obj->attribute = "value";

$l->error($e);
$l->debug($arr);
$l->debug($obj);
````