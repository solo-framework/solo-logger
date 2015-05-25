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

class IpParser extends BaseParser
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
		$ip = !empty($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : 'unavailable';
		return str_replace("{ip-address}", $ip, $this->pattern);
	}
}

