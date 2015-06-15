<?php
/**
 *
 *
 * PHP version 5
 *
 * @package
 * @author  Andrey Filippov <afi@i-loto.ru>
 */

namespace Solo\Logger\Parsers;

use Solo\Logger\LogRecord;

class BoolParser extends BaseParser
{

	/**
	 * Замена макросов в шаблоне лога на значения
	 *
	 * @return LogRecord
	 */
	public function parse()
	{
		if (is_bool($this->record->context))
		{
			$ctx = $this->record->context? "TRUE" : "FALSE";
			$this->record->formatted = str_replace("{log-context}", $ctx, $this->record->formatted);
			return $this->record;
		}
		else
		{
			return $this->record;
		}
	}
}

