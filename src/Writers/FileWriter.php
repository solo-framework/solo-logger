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

class FileWriter extends BaseWriter
{
	public $output = "./log.txt";

	function write($level, $data)
	{
		$fp = fopen($this->output, "a");
		flock($fp, LOCK_EX);
		fwrite($fp, $data);
		flock($fp, LOCK_UN);
		fclose($fp);
	}
}

