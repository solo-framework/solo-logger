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

use Solo\Logger\LogRecord;

class ConsoleWriter extends BaseWriter
{
	function write($level, LogRecord $data)
	{
		print $data->formatted;
	}
}

