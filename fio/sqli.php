<?php //*** oSQLi - ... » Fio™ © 2025 ∞ OE2i™ • www.oe2i.com ∞ Apache License ***//

namespace Fio;

use mysqli;

class oSQLi
{
	// • property
	protected static $mysqli;



	// • === tryCatch »
	private static function tryCatch(callable $callback, $default = null, $caller = 'SQLi')
	{
		return Fio::tryCatch($callback, $default, $caller);
	}



	// • === error »
	private static function error($message, $extra = null)
	{
		return Fio::kill(['title' => 'SQLi', 'message' => $message], $extra);
	}



	// • === connect »
	public static function connect()
	{
		$dba = Fio::property('database');
		self::$mysqli = self::tryCatch(fn() => new mysqli($dba->host, $dba->username, $dba->password, $dba->database));
		self::$mysqli->set_charset("utf8mb4");
		return self::$mysqli;
	}



	// • === query »
	public static function query($sql)
	{
		return self::$mysqli->query($sql);
	}



	// • === disconnect »
	public static function disconnect()
	{
		return self::$mysqli->close();
	}
}
