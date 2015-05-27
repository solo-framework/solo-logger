<?php
/**
 * Created by PhpStorm.
 * User: afi
 * Date: 5/26/15
 * Time: 11:35 PM
 */

namespace Solo\Logger;


class LogRecord
{
	public $loggerName = null;
	public $level = null;
	public $message = null;
	public $context = null;
	public $formatted = "";
	public $datetime = null;

	public function __construct()
	{
		$this->datetime = time();//date("c");//\DateTime::createFromFormat('U.u', sprintf('%.6F', microtime(true)));
	}
}