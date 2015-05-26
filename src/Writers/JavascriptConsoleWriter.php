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

class JavascriptConsoleWriter extends BaseWriter
{

	function write($level, $data)
	{
		$data = json_encode($data);
		$output = "<script type='application/javascript'>console.log('{$data}');</script>";
		echo $output;
	}
}

