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

class ObjectParser extends BaseParser
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
		if (is_object($data))
		{
			return str_replace("{message}", print_r($data, 1), $this->pattern);
		}
		else
		{
			return $this->pattern;
		}
	}
}

