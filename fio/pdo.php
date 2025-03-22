<?php //*** oPDO - ... » Fio™ © 2025 ∞ OE2i™ • www.oe2i.com ∞ Apache License ***//

namespace Fio;

use PDO;

class oPDO
{
	// • property
	protected static $pdo;



	// • === tryCatch »
	private static function tryCatch(callable $callback, $default = null, $caller = 'PDO')
	{
		return Fio::tryCatch($callback, $default, $caller);
	}



	// • === error »
	private static function error($message, $extra = null)
	{
		return Fio::kill(['title' => 'PDO', 'message' => $message], $extra);
	}



	// • === connect »
	public static function connect()
	{
		$dba = Fio::property('database');
		self::$pdo = self::tryCatch(
			fn() =>
			new PDO(
				"mysql:host=$dba->host;dbname=$dba->database;charset=utf8mb4",
				$dba->username,
				$dba->password,
				[
					PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, // Enable exceptions
					PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, // Fetch as associative array
					PDO::ATTR_EMULATE_PREPARES => false // Prevent SQL injection
				]
			)
		);
		return self::$pdo;
	}



	// • === query »
	public static function query($sql)
	{
		return self::$pdo->query($sql);
	}



	// • === select »
	public static function select($table, $column = '*', $params = [], $filter = null)
	{
		$stmt = self::$pdo->prepare("SELECT {$column} FROM `{$table}` {$filter}");
		$stmt->execute($params);
		return $stmt->fetchAll();
	}



	// • === disconnect »
	public static function disconnect()
	{
		return self::$pdo = null;
	}
}
