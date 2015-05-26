<?php
/**
 *
 *
 * PHP version 5
 *
 * @package
 * @author  Andrey Filippov <afi@i-loto.ru>
 */

namespace Solo\Logger;

use Solo\Logger\Writers\BaseWriter;

class Logger
{
	/**
	 * Name of logger
	 *
	 * @var string
	 */
	public $name = null;

	/**
	 * Enabled\disabled
	 *
	 * @var bool
	 */
	public $enabled = true;

	/**
	 * Pattern of log message
	 *
	 * @var string
	 */
	public $format = "{date-time} {level},{logger-name}: {message}\n";

	/**
	 * Levels
	 *
	 * @var array
	 */
	public static $levels = array(
		100 => 'DEBUG',
		200 => 'INFO',
		250 => 'NOTICE',
		300 => 'WARNING',
		400 => 'ERROR',
		500 => 'CRITICAL',
		550 => 'ALERT',
		600 => 'EMERGENCY',
	);

	protected static $instances = array();

	/**
	 * @var BaseWriter[]
	 */
	protected $writers = array();

	private static $settings = array(

		// List of loggers
		"loggers" => [
			"default" => [
				"enabled" => true,
				"writers" => ["default"],
//				"format" => "{date-time} {log-level},{logger-name}: {message}\n"
			]
		],

		// List of writing ways
		"writers" => [

			"default" => [
				"enabled" => true,
				"level" => Level::DEBUG,
				"class" => "Solo\\Logger\\Writers\\ConsoleWriter",
				"ignoreErrors" => true,
				"writeOnlyCurrentLevel" => false,
				"options" => [ ]
			]
		],

		// List of classes to parse and fill log patterns
		"parsers" => [
			"builtin" => "Solo\\Logger\\Parsers\\BuiltInParser",
			"exception" => "Solo\\Logger\\Parsers\\ExceptionParser",
			"resource" => "Solo\\Logger\\Parsers\\ResourceParser",
			"array" => "Solo\\Logger\\Parsers\\ArrayParser",
			"string" => "Solo\\Logger\\Parsers\\StringParser",
			"object" => "Solo\\Logger\\Parsers\\ObjectParser",
			"ip" => "Solo\\Logger\\Parsers\\IpParser",
			"env" => "Solo\\Logger\\Parsers\\EnvParser",
		]
	);

	/**
	 * Ctor
	 *
	 * @param string $name Name of logger
	 */
	public function __construct($name)
	{
		$this->name = $name;
	}

	/**
	 * Init the logger
	 *
	 * @param mixed $settings
	 *
	 * @return void
	 */
	public static function init($settings = null)
	{
		if (!is_null($settings))
			self::$settings = array_replace_recursive(self::$settings, $settings);
	}

	/**
	 * @param null $name
	 *
	 * @return Logger
	 */
	public static function get($name = null)
	{
		if (!$name)
			$name = "default";

		if (array_key_exists($name, self::$instances))
		{
			return self::$instances[$name];
		}
		else
		{
			$opts = @self::$settings["loggers"][$name];
			if (!$opts)
				throw new \RuntimeException("Logger '{$name}' is not defined");

			$logger = new Logger($name);
			$logger->format = self::getOption($opts, "format", "{date-time} [{log-level}] {logger-name}: {message}\n");//$opts["format"];
			$logger->enabled = self::getOption($opts, "enabled", true);

			foreach ($opts["writers"] as $wr)
				$logger->addWriter($wr);

			self::$instances["name"] = $logger;
			return $logger;
		}
	}

	protected function addWriter($name)
	{
		$opts = @self::$settings["writers"][$name];
		if (!$opts)
			throw new \RuntimeException("Logger: can't create writer {$name}");

		$className = $opts["class"];
		$rc = new \ReflectionClass($className);
		$writer = $rc->newInstance();
		$writer->level =                 self::getOption($opts, "level", Level::DEBUG);//$opts["level"];
		$writer->ignoreErrors =          self::getOption($opts, "ignoreErrors", true);
		$writer->enabled =               self::getOption($opts, "enabled", true);
		$writer->writeOnlyCurrentLevel = self::getOption($opts, "writeOnlyCurrentLevel", false);

		foreach ($opts["options"] as $k => $v)
			$writer->$k = $v;

		$this->writers[$name] = $writer;
	}

	protected static function getOption($list, $key, $default)
	{
		if (array_key_exists($key, $list))
			return $list[$key];
		else
			return $default;
	}

	/**
	 * Write a message
	 *
	 * @param int $level Log level
	 * @param mixed $message Message
	 *
	 * @throws \Exception
	 */
	public function write($level, $message)
	{
		if ($this->enabled)
		{
			$res = $this->format;
			foreach (self::$settings["parsers"] as $name => $className)
			{
				$inst = new $className($res);
				$res = $inst->parse($this->name, $level, $message);
			}

			foreach ($this->writers as $writer)
				$writer->handle($level, $res);
		}
	}

	public function debug($message)
	{
		$this->write(Level::DEBUG, $message);
	}

	public function error($message)
	{
		$this->write(Level::ERROR, $message);
	}

	public function info($message)
	{
		$this->write(Level::INFO, $message);
	}

	public function notice($message)
	{
		$this->write(Level::NOTICE, $message);
	}

	public function warning($message)
	{
		$this->write(Level::WARNING, $message);
	}

	public function critical($message)
	{
		$this->write(Level::CRITICAL, $message);
	}

	public function alert($message)
	{
		$this->write(Level::ALERT, $message);
	}

	public function emergency($message)
	{
		$this->write(Level::EMERGENCY, $message);
	}
}

