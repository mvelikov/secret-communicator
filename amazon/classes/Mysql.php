<?php

class Mysql
{
	private $host = 'instance15546.db.xeround.com:10404';
	private $username = 'mvelikov';
	private $password = 'impXer23';
	private $database = 'telerik_hw';
	private $connection;
	private $result;

	public function __construct()
	{
//		 $con = new mysqli('instance15546.db.xeround.com', $this->username, $this->password, $this->database, 10404);
//		 var_dump($con);
		$this->connection = mysql_connect($this->host, $this->username, $this->password);
		if (!$this->connection) {
			die('Could not connect: ' . mysql_error());
		}
		mysql_select_db($this->database, $this->connection);
		mysql_query("SET NAMES `utf8`");
	}

	public function __descruct()
	{
		mysql_close($this->connection);
	}

	public function query($sql)
	{
		$this->result = mysql_query($sql, $this->connection) OR die(mysql_error());
		return $this->result;
	}

	public function fetch()
	{
		if (is_resource($this->result)) {
			return mysql_fetch_assoc($this->result);
		} else {
			return false;
		}
	}

	public function fetch_all()
	{
		$result = array();
		if (is_resource($this->result)) {
			while($row = mysql_fetch_assoc($this->result)) {
				$result[] = $row;
			}
		}
		return $result;
	}

	public function safe($string)
	{
		return mysql_real_escape_string($string);
	}
}