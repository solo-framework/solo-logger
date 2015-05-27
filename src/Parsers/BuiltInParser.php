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
		$res = str_replace("{log-name}", $this->record->loggerName, $res);
		$res = str_replace("{log-message}", $this->record->message, $res);
		$res = str_replace("{date-time}", date("c", $this->record->datetime), $res);

		// если контекст не был задан, то удалим макрос
		$res = str_replace("{log-context}", "none", $res);

		$this->record->formatted = $res;
		return $this->record;
	}
}

