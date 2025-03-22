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



	// • === prepare »
	public static function prepare($sql, $param = [], $action = null)
	{
		return self::tryCatch(function () use ($sql, $param, $action) {
			$sql = trim($sql);
			$stmt = self::$pdo->prepare($sql);

			foreach ($param as $key => &$value) {
				$stmt->bindParam(":$key", $value);
			}

			$execute = $stmt->execute();

			if (preg_match('/^\s*(INSERT|UPDATE|DELETE)\b/i', $sql) || $action === 'execute') {
				return $execute;
			} elseif ($action === 'fetch') {
				return $stmt->fetch();
			}

			return $stmt->fetchAll();
		});
	}



	// • === lastID »
	public static function lastID()
	{
		return self::$pdo->lastInsertId();
	}



	// • === create »
	public static function create($table, $param, $action = 'execute')
	{
		$keys = array_keys($param);
		$columns = implode(", ", $keys);
		$placeholders = ':' . implode(", :", $keys);
		$sql = "INSERT INTO `{$table}` ({$columns}) VALUES ({$placeholders})";
		// Fio::dump($sql);
		return self::prepare($sql, $param, $action);
	}



	// • === disconnect »
	public static function disconnect()
	{
		return self::$pdo = null;
	}
}
