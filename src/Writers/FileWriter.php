<?php
/**
 * Writes log recort into file
 *
 * 	"writers" => [
		"file" => [
 *          "enabled" => true, // optional
			"level" => Level::DEBUG, // required
			"class" => "Solo\\Logger\\Writers\\FileWriter", // required
			"writeOnlyCurrentLevel" => true, // optional
			"ignoreErrors" => false, // optional
			"options" => [
				"output" => "debug-log.txt", // required
				"split" => false, // optional
				"splitSize" => 1024, // optional
			]
		],
 *
 * PHP version 5
 *
 * @package
 * @author  Andrey Filippov <afi.work@gmail.com>
 */

namespace Solo\Logger\Writers;

use Solo\Logger\Logger;
use Solo\Logger\LogRecord;

class FileWriter extends BaseWriter
{
	/**
	 * File to output
	 *
	 * @var string
	 */
	public $output = "./log.txt";

	/**
	 * If true, log files will be split on multiple files with an autoincrement digit at the end of each file
	 *
	 * @var bool
	 */
	public $split = false;

	/**
	 * File size in Kb
	 *
	 * @var int
	 */
	public $splitSize = 512;

	/**
	 * The parameter consists of three octal number components specifying access restrictions for the owner,
	 * the user group in which the owner is in, and to everybody else in this order.
	 * One component can be computed by adding up the needed permissions for that target user base.
	 * Number 1 means that you grant execute rights, number 2 means that you make the file writeable,
	 * number 4 means that you make the file readable. Add up these numbers to specify needed rights.
	 * You can also read more about modes on Unix systems with 'man 1 chmod' and 'man 2 chmod'.
	 *
	 * @var int
	 */
	public $mode = 0777;


	function write($level, LogRecord $data)
	{
		$output = str_replace("{log-level}", Logger::$levels[$data->level], $this->output);

		if (!is_file($output))
			$this->createFullPath($output);

		if ($this->split)
		{
			if (is_file($output))
			{
				clearstatcache(null, $output);
				$size = filesize($output) / 1024;

				$dataSize = mb_strlen($data->formatted) / 1024;
				if ($size + $dataSize > $this->splitSize)
				{
					$fi = new \SplFileInfo(realpath($output));
					$realPath = $fi->getRealPath();
					$files = glob($realPath. ".*");

					usort($files, function ($a, $b) {
						return strcmp($b, $a);
					});

					$ids[] = 1;
					$index = 1;
					if (count($files))
					{
						foreach ($files as $file)
						{
							preg_match("%{$fi->getRealPath()}\.?([0-9]*)$%", $file, $matches);
							$ids[] = $matches[1];
						}
						$index = max($ids) + 1;
					}
					rename($output, $output . "." . $index);
				}
			}
		}

		$fp = fopen($output, "a");
		chmod($output, $this->mode);
		flock($fp, LOCK_EX);
		fwrite($fp, $data->formatted);
		flock($fp, LOCK_UN);
		fclose($fp);
	}

	function createFullPath($path)
	{
		$dir = pathinfo($path , PATHINFO_DIRNAME);
		if (is_dir($dir))
		{
			return true;
		}
		else
		{
			if ($this->createFullPath($dir))
			{
				if (mkdir($dir) && chmod($dir, $this->mode))
				{
					return true;
				}
			}
		}
		return false;
	}
}

