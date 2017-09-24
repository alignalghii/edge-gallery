<?php

namespace framework\ORM;

class Statement
{
	private $dbh;
	private $stmt;

	/**
	 * @todo dependency injection for trigger text parsing in exception message,
	 *       or raise this classification onto a higher or abstracter level
	 */
	public function __construct($sql, $typedBindings = array())
	{
		try {
			$this->dbh  = DbConn::get();
			$this->stmt = $this->dbh->prepare($sql);

			if ($this->stmt) {
				foreach ($typedBindings as $placeholder => $typedValue) {
					list($value, $type) = $typedValue;
					$this->stmt->bindValue($placeholder, $value, $type);
				}
				$this->stmt->execute();
			} // else ...
		} catch (\Exception $e) {
            $message = $e->getMessage();
			if (preg_match('/Membership limit of ([0-9]+) exceeded/', $message, $match)) {
				throw new MyTriggerException($sql, $typedBindings, $match[1]);
			}
			if (preg_match("/Duplicate entry '(.*)' for key '(.*)'/", $message, $match)) {
				throw new MyUniquenessException($sql, $typedBindings, $match[1], $match[2]);
			}
			throw $e;
		}
	}

	public function queryOneOrAll($one)
	{
		if ($one) {
			return $this->stmt->fetch(\PDO::FETCH_ASSOC);
		} else {
			return $this->stmt->fetchAll(\PDO::FETCH_ASSOC);
		}
	}
}
