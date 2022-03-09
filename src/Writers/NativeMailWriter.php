<?php
/**
 * Created by PhpStorm.
 * User: afi
 * Date: 5/28/15
 * Time: 11:03 PM
 */

namespace Solo\Logger\Writers;

use Solo\Logger\Logger;
use Solo\Logger\LogRecord;

class NativeMailWriter extends BaseWriter
{
	/**
	 * String or rray  of e-mails
	 *
	 * @var string|array
	 */
	public $to = "";
	public $subject = "{log-level} {message}";
	public $from = "";
	public $contentType = 'text/plain';
	public $encoding = 'utf-8';

	function write($level, LogRecord $data)
	{
		$headers[] = "From: {$this->from}";

		$headers = ltrim(implode("\r\n", $headers) . "\r\n", "\r\n");
		$headers .= "Content-type: {$this->contentType}; charset={$this->encoding}\r\n";

		if ($this->contentType == "text/html" && false === strpos($headers, "MIME-Version:"))
			$headers .= 'MIME-Version: 1.0' . "\r\n";

		$this->subject = str_replace("{log-level}", Logger::$levels[$data->level], $this->subject);
		$this->subject = str_replace("{message}", (string)$data->message, $this->subject);

		foreach ($this->to as $to)
			mail($to, $this->subject, $data->formatted, $headers);
	}
}