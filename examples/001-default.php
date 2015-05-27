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

Logger::init();
$logger = Logger::get();

// Write a text message
$logger->debug("Some message");

// Writes an array
$array = [1, 2, "value"];
$logger->debug("Log array", $array);
