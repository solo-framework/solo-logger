<?php
/**
 *
 *
 * PHP version 5
 *
 * @package
 * @author  Andrey Filippov <afi.work@gmail.com>
 */

namespace Solo\Logger\Writers;

use Solo\Logger\LogRecord;

class JavascriptConsoleWriter extends BaseWriter
{

	function write($level, LogRecord $data)
	{
		$data = json_encode($data->formatted);
		$output = "<script type='application/javascript'>console.log('{$data}');</script>";
		echo $output;
	}
}

