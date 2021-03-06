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

class ShortExceptionParser extends BaseParser
{

	/**
	 * Замена макросов в шаблоне лога на значения
	 *
	 * @return LogRecord
	 */
	public function parse()
	{
		if ($this->record->context instanceof \Exception)
		{
			$this->record->formatted = str_replace("{short-exc}", print_r($this->record->context->getMessage(), 1), $this->record->formatted);
		}
		return $this->record;
	}
}

