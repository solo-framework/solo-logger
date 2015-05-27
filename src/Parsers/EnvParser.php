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

class EnvParser extends BaseParser
{
	/**
	 * Замена макросов в шаблоне лога на значения
	 *
	 * @return LogRecord
	 */
	public function parse()
	{
		$matches = array();

		// строка вида {env._SERVER.LC_NAME}
		if (preg_match('/\{env\.([\w\.]+)\}/im', $this->record->formatted, $matches) > 0)
		{
			$parts = explode(".", $matches[1]);
			$array = @$GLOBALS[$parts[0]];

			array_shift($parts);
			$val = $array;
			foreach ($parts as $key)
				$val = $val[$key];

			if (is_array($val))
				$val = print_r($val, 1);

			$this->record->formatted = str_replace($matches[0], $val, $this->record->formatted);
		}

		return $this->record;
	}
}

