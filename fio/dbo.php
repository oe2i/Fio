<?php //*** oDBO » Fio™ © 2025 ∞ OE2i™ • www.oe2i.com ∞ Apache License ***//

namespace Fio;

class oDBO
{
	// • property
	private static bool $init = false;
	private static string $type = 'pdo';
	protected static $connection;
	protected static $dbc;



	// • === init »
	public static function init($type = null)
	{
		if (!self::$init) {
			$dba = Fio::property('database');
			$e['title'] = 'Database';

			if (!is_object($dba)) {
				$e['message'] = 'error in configuration';
				return Fio::kill($e);
			}

			if (empty(get_object_vars($dba))) {
				$e['message'] = 'missing configuration';
				return Fio::kill($e);
			}

			// ... set connection type
			self::$type = !empty($type) ? $type : (!empty($dba->type) ? $dba->type : 'pdo');

			// ... use connection type
			if (self::$type === 'pdo') {
				self::$dbc = new oPDO();
				self::$connection = self::$dbc::connect();
			} elseif (self::$type === 'sqli') {
				self::$dbc = new oSQLi();
				self::$connection = self::$dbc::connect();
			}

			self::$init = true;
		}
	}



	// • === dbc »
	public static function dbc($type = null)
	{
		if (!self::$dbc) {
			self::init($type);
		}
		return self::$dbc;
	}



	// • === prepare »
	public function prepare($sql, $param = [], $action = null, $type = null)
	{
		return self::dbc($type)->prepare($sql, $param, $action);
	}



	// • === query »
	public static function query($sql, $param = [], $action = null, $type = null)
	{
		if (empty($param) && !$action) {
			return self::dbc($type)->query($sql);
		}
		return self::dbc($type)->prepare($sql, $param, $action);
	}



	// • === lastID »
	public static function lastID($type = null)
	{
		return self::dbc($type)->lastID();
	}


	// • === create »
	public static function create($table, $param, $action = 'execute', $type = null)
	{
		return self::dbc($type)->create($table, $param, $action);
	}



	// • === read »
	public static function read($table, $column = '*', $filter = null, $action = 'fetchAll', $type = null)
	{
		return self::dbc($type)->read($table, $column, $filter, $action);
	}



	// • === update »
	public static function update($table, $param = null, $filter = null, $action = 'execute', $type = null)
	{
		return self::dbc($type)->update($table, $param, $filter, $action);
	}



	// • === delete »
	public static function delete($table, $filter = null, $action = 'execute', $type = null)
	{
		return self::dbc($type)->delete($table, $filter, $action);
	}


	// • === find »
	public static function find($table, $column = '*', $filter = null, $type = null)
	{
		return self::dbc($type)->find($table, $column, $filter);
	}



	// • === findAll »
	public static function findAll($table, $column = '*', $type = null)
	{
		return self::dbc($type)->findAll($table, $column);
	}
}
