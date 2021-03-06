<?php
/**
 *
 *
 * PHP version 5
 *
 * @package
 * @author  Andrey Filippov <afi.work@gmail.com>
 */

namespace Solo\Logger\Parsers;

use Solo\Logger\LogRecord;

class ExceptionParser extends BaseParser
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
			$this->record->formatted = str_replace("{log-context}", print_r($this->record->context, 1), $this->record->formatted);
		}
		return $this->record;
	}
}

