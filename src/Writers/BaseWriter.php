<?php
/**
 *
 *
 * PHP version 5
 *
 * @package
 * @author  Andrey Filippov <afi@i-loto.ru>
 */

namespace Solo\Logger\Writers;

use Solo\Logger\Level;

abstract class BaseWriter
{
	/**
	 * Can write messages which have this level and bigger
	 *
	 * @var int
	 */
	public $level = Level::DEBUG;

	/**
	 * Ignore errors in the "write" method
	 *
	 * @var bool
	 */
	public $ignoreErrors = true;

	/**
	 * Write messages which correspond the current level only
	 *
	 * @var bool
	 */
	public $writeOnlyCurrentLevel = false;

	abstract function write($level, $data);

	public function handle($level, $message)
	{
		$canWrite = false;
		if ($this->writeOnlyCurrentLevel && ($this->level == $level))
			$canWrite = true;
		if (!$this->writeOnlyCurrentLevel && ($level >= $this->level))
			$canWrite = true;

		if ($canWrite)
		{
			try
			{
				$this->write($level, $message);
			}
			catch (\Exception $e)
			{
				if ($this->ignoreErrors)
					return;
				else
					throw $e;
			}
		}
	}
}

