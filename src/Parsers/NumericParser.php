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

class NumericParser extends BaseParser
{

	/**
	 * Замена макросов в шаблоне лога на значения
	 *
	 * @return LogRecord
	 */
	public function parse()
	{
		if (is_numeric($this->record->context))
		{
			$this->record->formatted = str_replace("{log-context}", (string)$this->record->context, $this->record->formatted);
			return $this->record;
		}
		else
		{
			return $this->record;
		}
	}
}

