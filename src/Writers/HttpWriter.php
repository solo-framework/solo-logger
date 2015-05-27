<?php
/**
 * Sends messages to HTTP server
 *
 * 	"writers" => [
		"http" => [
			"level" => Level::DEBUG,
			"class" => "Solo\\Logger\\Writers\\HttpWriter",
			"writeOnlyCurrentLevel" => false,
			"ignoreErrors" => true,
			"options" => [ "url" => "http://my-log-server.com/log" ]
		],
 *
 * PHP version 5
 *
 * @package
 * @author  Andrey Filippov <afi.work@gmail.com>
 */

namespace Solo\Logger\Writers;

use Solo\Logger\LogRecord;

class HttpWriter extends BaseWriter
{
	public $url = "http://localhost/";

	function write($level, LogRecord $data)
	{
		$ctx = stream_context_create(array("http" => array(
			"method" => "POST",
			"header" => "Content-type: application/x-www-form-urlencoded\r\n" . "Content-Length: " . strlen($data->formatted) . "\r\n",
			"content" => $data->formatted
		)));

		$res = @file_get_contents($this->url, false, $ctx);
		if (!$res)
		{
			$last = error_get_last();
			$error = @$last["message"];
			throw new \RuntimeException("HttpWriter error: {$error}");
		}
	}
}

