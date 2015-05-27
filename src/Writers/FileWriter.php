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
//		print_r($this->level);
		$this->output = str_replace("{log-level}", Logger::$levels[$data->level], $this->output);

		if ($this->split)
		{
			if (is_file($this->output))
			{
				$size = filesize($this->output) / 1024;
				$dataSize = mb_strlen($data->formatted) / 1024;
				if ($size + $dataSize > $this->splitSize)
				{
					$fi = new \SplFileInfo(realpath($this->output));
					$realPath = $fi->getRealPath();
					$files = glob($realPath. ".*");

					usort($files, function ($a, $b) {
						return strcmp($b, $a);
					});

					$index = 1;
					if (count($files))
					{
						$firstFile = realpath($files[0]);
						preg_match("%{$fi->getRealPath()}\.?([0-9]*)$%", $firstFile, $matches);
						$index = $matches[1] + 1;

					}
					rename($this->output, $this->output . "." . $index);
				}
			}
		}

		$fp = fopen($this->output, "a");
		flock($fp, LOCK_EX);
		fwrite($fp, $data->formatted);
		flock($fp, LOCK_UN);
		fclose($fp);
	}
}

