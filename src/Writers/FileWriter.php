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
				if (mkdir($dir))
					return true;
			}
		}
		return false;
	}
}

