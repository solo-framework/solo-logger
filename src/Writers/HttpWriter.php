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
 * @author  Andrey Filippov <afi@i-loto.ru>
 */

namespace Solo\Logger\Writers;

class HttpWriter extends BaseWriter
{
	public $url = "http://localhost/";

	function write($level, $data)
	{
		$ctx = stream_context_create(array("http" => array(
			"method" => "GET",
			"header" => "Content-type: application/x-www-form-urlencoded\r\n" . "Content-Length: " . strlen($data) . "\r\n",
			"content" => $data
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

