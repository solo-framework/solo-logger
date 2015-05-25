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

class ResourceParser extends BaseParser
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
		if (is_resource($data))
		{
			return str_replace("{message}", "Resource type: " . get_resource_type($data), $this->pattern);
		}
		else
		{
			return $this->pattern;
		}
	}
}

