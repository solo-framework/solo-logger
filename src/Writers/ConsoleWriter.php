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

class ConsoleWriter extends BaseWriter
{
	function write($level, $data)
	{
		print $data;
	}
}

