<?php

require_once ('Mysql.php');
class Base
{
	protected $table = '';
	protected $db;
	protected $ignore = false;

	public function __construct()
	{
		$this->db = new Mysql();
	}

	public function insert($options)
	{
		$glue = $sql_columns = $sql_values = '';
		if (is_array($options)) {
			foreach ($options as $column => $value) {
				$sql_columns .= $glue . sprintf(" %s ", $this->db->safe($column));
				if (is_int($value)) {
					$sql_values .= $glue . sprintf(" %d ", $value);
				} elseif (is_float($value)) {
					$sql_values .= $glue . sprintf(" %f", $value);
				} else {
					$sql_values .= $glue . sprintf(" '%s' ", $value);
				}
				$glue = ',';
			}
		}

		if ($sql_columns != '' && $sql_values != '') {
			if ($this->ignore) {
				$sql = "INSERT IGNORE ";
			} else {
				$sql = "INSERT ";
			}

			$sql .= sprintf("INTO %s ( %s )
				VALUES (%s)",
				$this->table,
				$sql_columns,
				$sql_values);

			$this->db->query($sql);
		}
	}

	public function update($options = array())
	{
		$sql_where = $sql_clause = $glue = '';
		if (!empty($options['data']) && is_array($options['data'])) {
			foreach ($options['data'] as $column => $value) {
				if (is_int($value)) {
					$value = $glue . sprintf(" %d ", $value);
				} elseif (is_float($value)) {
					$value = $glue . sprintf(" %f", $value);
				} else {
					$value = $glue . sprintf(" '%s' ", $value);
				}
				$sql_clause .= $glue . sprintf(" %s = %s ",
					$this->db->safe($column),
					$value);
				$glue = ',';
			}
		}
		$glue = '';
		if (!empty($options['where']) && is_array($options['where'])) {
			foreach($options['where'] as $column => $value) {
				if (is_int($value)) {
					$value = $glue . sprintf(" %d ", $value);
				} elseif (is_float($value)) {
					$value = $glue . sprintf(" %f", $value);
				} else {
					$value = $glue . sprintf(" '%s' ", $value);
				}
				$sql_where .= $glue . sprintf(" %s = %s ",
					$this->db->safe($column),
					$value);
				$glue = ',';
			}
		}
		if ($sql_clause != '') {
			$sql = sprintf("UPDATE %s SET %s".
				$this->table,
				$sql_clause);
			if ($sql_where != '') {
				$sql .= sprintf(' WHERE %s ', $sql_where);
			}
			$this->db->query($sql);
		}
	}

	public function select($options = array(), $limit = false)
	{
		$sql_where = $sql_clause = $glue = '';
		if (is_array($options)) {
			foreach ($options as $column => $value) {
				if (is_int($value)) {
					$value = $glue . sprintf(" %d ", $value);
				} elseif (is_float($value)) {
					$value = $glue . sprintf(" %f", $value);
				} else {
					$value = $glue . sprintf(" '%s' ", $value);
				}
				$sql_where .= $glue . sprintf(" %s = %s ",
					$this->db->safe($column),
					$value);
				$glue = ',';
			}

			$sql = sprintf("SELECT * FROM %s", $this->table);
			if ($sql_where != '') {
				$sql .= sprintf(" WHERE %s", $sql_where);
			}
			if ($limit > 0) {
				$sql .= sprintf(" LIMIT %d", $limit);
			}
			$sql .= ' ORDER BY id';
			$this->db->query($sql);
		}
		return $this;
	}

	public function fetch_all()
	{
		return $this->db->fetch_all();
	}

	public function fetch_row()
	{
		return $this->db->fetch();
	}

	public function set_ignore($bool)
	{
		$this->ignore = (boolean) $bool;
	}

}