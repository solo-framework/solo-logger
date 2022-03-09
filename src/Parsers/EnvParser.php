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
		if (preg_match_all('/\{env\.([\w\.]+)\}/im', $this->record->formatted, $macrosList) > 0)
		{
			foreach ($macrosList[1] as $match)
			{
				$parts = explode(".", $match);
				$array = @$GLOBALS[$parts[0]];
				array_shift($parts);
				$val = $array;

				foreach ($parts as $i => $key)
				{
					if (is_array($val))
						$val = @$val[$key];
					else if (is_object($val))
						$val = $val->{$key};
				}

				if (is_array($val) || is_object($val))
					$val = print_r($val, 1);

				if (is_null($val))
					$val = [];
				$this->record->formatted = str_replace("{env." . $match . "}", $val, $this->record->formatted);
			}
		}

		return $this->record;
	}
}

