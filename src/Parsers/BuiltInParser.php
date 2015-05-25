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
	 * @param string $loggerName
	 * @param int $level
	 * @param mixed $data Данные для записи в лог
	 *
	 * @return mixed
	 */
	public function parse($loggerName, $level, $data)
	{
		$res = str_replace("{log-level}", Logger::$levels[$level], $this->pattern);
		$res = str_replace("{logger-name}", $loggerName, $res);
		$res = str_replace("{date-time}", date("c"), $res);
		return $res;
	}
}

