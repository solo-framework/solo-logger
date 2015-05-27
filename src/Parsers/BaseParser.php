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

use Solo\Logger\LogRecord;

abstract class BaseParser
{
	public $record = null;

	public function __construct(LogRecord $record)
	{
		$this->record = $record;
	}

	/**
	 * Замена макросов в шаблоне лога на значения
	 *
	 * @return LogRecord
	 */
	public abstract function parse();
}

