<?php
/**
 *
 *
 * PHP version 5
 *
 * @package
 * @author  Andrey Filippov <afi.work@gmail.com>
 */

namespace Solo\Logger;

use Solo\Core\IApplicationComponent;

class Adapter implements IApplicationComponent
{
	public $settings = array();

	/**
	 * Инициализация компонента
	 *
	 * @see IApplicationComponent::initComponent()
	 *
	 * @return boolean
	 **/
	public function initComponent()
	{
		Logger::init($this->settings);
		return true;
	}
}

