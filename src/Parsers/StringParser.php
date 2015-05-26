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

class StringParser extends BaseParser
{
	/**
	 * Замена макросов в шаблоне лога на значения
	 *
	 * @return LogRecord
	 */
	public function parse()
	{
		if (is_string($this->record->context))
			$this->record->formatted = str_replace("{context}", $this->record->context, $this->record->formatted);

		return $this->record;
	}
}

