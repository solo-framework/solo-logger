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

use Solo\Logger\Logger;

class BuiltInParser extends BaseParser
{

	/**
	 * Замена макросов в шаблоне лога на значения
	 *
	 * @return LogRecord
	 */
	public function parse(/*$loggerName, $level, $data*/)
	{
		$res = str_replace("{log-level}", Logger::$levels[$this->record->level], $this->record->formatted);
		$res = str_replace("{logger-name}", $this->record->loggerName, $res);
		$res = str_replace("{message}", $this->record->message, $res);
		$res = str_replace("{date-time}", $this->record->datetime, $res);
		$this->record->formatted = $res;
		return $this->record;
	}
}

