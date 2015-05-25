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

class EnvParser extends BaseParser
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
		$matches = array();

		// строка вида {env._SERVER.LC_NAME}
		if (preg_match('/\{env\.([\w\.]+)\}/im', $this->pattern, $matches) > 0)
		{
			$parts = explode(".", $matches[1]);
			$array = @$GLOBALS[$parts[0]];

			array_shift($parts);
			$val = $array;
			foreach ($parts as $key)
				$val = $val[$key];

			if (is_array($val))
				$val = print_r($val, 1);

			return str_replace($matches[0], $val, $this->pattern);
		}

		return $this->pattern;
	}
}

