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



	// • === query »
	public static function query($sql, $type = null)
	{
		return self::dbc($type)->query($sql);
	}



	// • === select »
	public static function select($table, $column = '*', $params = [], $filter = null, $type = null)
	{
		return self::dbc($type)->select($table, $column, $params, $filter);
	}
}
