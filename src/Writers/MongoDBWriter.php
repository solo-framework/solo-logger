<?php
/**
 * Created by PhpStorm.
 * User: afi
 * Date: 5/28/15
 * Time: 10:35 PM
 */

namespace Solo\Logger\Writers;


use Solo\Logger\LogRecord;

class MongoDBWriter extends BaseWriter
{
	/**
	 * Connection string
	 *
	 * @var string
	 */
	public $server = "mongodb://username:password@localhost:27017";

	/**
	 * Database name
	 *
	 * @var string
	 */
	public $dbname = "";

	/**
	 * Collection
	 *
	 * @var string
	 */
	public $collection = "logs";

	protected $coll = null;

	function write($level, LogRecord $data)
	{
		if (!$this->coll)
		{
			$this->coll = new \MongoClient($this->server);
			$db = $this->coll->selectDB($this->dbname);
			$this->coll = $db->selectCollection($this->collection);
		}

		unset($data->context);
		$data = (array)$data;
		$this->coll->save($data);
	}
}