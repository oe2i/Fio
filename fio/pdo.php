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



	// • === where »
	public static function where($filter = null, &$param = null)
	{
		if ($filter) {

			// ... filter is array
			if (is_array($filter)) {
				if (empty($param)) {
					$param = $filter;
				} elseif (is_array($param)) {
					$param = array_merge($filter);
				}

				// » to string
				$bind = $filter;
				$filter = implode(' AND ', array_map(fn($key) => "$key = :$key", array_keys($bind)));
			}

			// ... filter is string
			if (is_string($filter)) {
				$filter = trim($filter);
				if (!preg_match('/^\s*WHERE\b/i', $filter)) {
					$filter = 'WHERE ' . $filter;
				}
			}
		}
		return $filter;
	}



	// • === create »
	public static function create($table, $param, $action = 'execute')
	{
		$keys = array_keys($param);
		$columns = implode(", ", $keys);
		$placeholders = ':' . implode(", :", $keys);
		$sql = "INSERT INTO `{$table}` ({$columns}) VALUES ({$placeholders})";
		return self::prepare($sql, $param, $action);
	}



	// ◈ === delete »
	public static function delete($table, $filter, $action = 'execute')
	{
		// $param = [];
		// $bindFilter = '';
		// if (!empty($filter)) {
		// 	if (is_array($filter)) {

		// 		foreach ($filter as $key => $value) {
		// 			$bindFilter .= $key . ' = :' . $key . ' AND ';
		// 		}
		// 		$bindFilter = trim($bindFilter, ' AND ');
		// 	} elseif (is_string($filter)) {
		// 		$bindFilter = $filter;
		// 	}
		// }






		$param = null;
		$filter = self::where($filter, $param);
		$sql = "DELETE FROM `{$table}` $filter";
		Fio::dump(['sql' => $sql, 'param' => $param]);
		// return self::prepare($sql, $param, $action);
	}



	// • === disconnect »
	public static function disconnect()
	{
		return self::$pdo = null;
	}
}
