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

abstract class BaseParser
{
	public $pattern = "{date-time} [{level}] {logger-name}: {message}\n";

	public function __construct($pattern)
	{
		$this->pattern = $pattern;
	}

	/**
	 * Замена макросов в шаблоне лога на значения
	 *
	 * @param string $loggerName
	 * @param int $level
	 * @param mixed $data Данные для записи в лог
	 *
	 * @return mixed
	 */
	public abstract function parse($loggerName, $level, $data);
}

