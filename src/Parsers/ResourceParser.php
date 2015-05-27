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

class ResourceParser extends BaseParser
{
	/**
	 * Замена макросов в шаблоне лога на значения
	 *
	 * @return LogRecord
	 */
	public function parse()
	{
		if (is_resource($this->record->context))
		{
			$this->record->formatted = str_replace("{log-context}", "Resource type: " . get_resource_type($this->record->context), $this->record->formatted);
		}

		return $this->record;
	}
}

