<?php //*** oDBO » Fio™ © 2025 ∞ OE2i™ • www.oe2i.com ∞ Apache License ***//

namespace Fio;

class oDBO
{
	// • property
	private static bool $init = false;
	private static string $type = 'pdo';
	protected static $connection;



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
				self::$connection = oPDO::connect();
			} elseif (self::$type === 'sqli') {
				self::$connection = oSQLi::connect();
			}

			self::$init = true;
		}
	}
}
