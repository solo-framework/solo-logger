<?php
/**
 *
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

		file_get_contents($this->url, false, null);
	}
}

