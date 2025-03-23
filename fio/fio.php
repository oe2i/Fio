<?php //*** Fio » Fio™ © 2025 ∞ OE2i™ • www.oe2i.com ∞ Apache License ***//

namespace Fio;

use Throwable;

class Fio
{
	// • property
	private static bool $init = false;
	protected static string $DS;
	protected static string $PS;
	protected static string $RD;
	protected static object $site;
	protected static object $database;


	// • === init »
	public static function init(array $prop)
	{
		if (!self::$init) {
			if (isset($prop['RD'])) {
				self::$RD = $prop['RD'];
			}
			if (isset($prop['site'])) {
				self::site($prop['site']);
			}
			if (isset($prop['database'])) {
				self::database($prop['database']);
			}
			self::$DS = DIRECTORY_SEPARATOR;
			self::$PS = '/';
			self::$init = true;
		}
	}



	// • === property »
	public static function property(string|array $prop)
	{
		// ➝ get property
		if (is_string($prop) && isset(self::${$prop})) {
			return self::${$prop};
		}

		// ➝ set property
		if (is_array($prop)) {
			foreach ($prop as $property => $value) {
				self::${$property} = $value;
			}
			return true;
		}

		return false;
	}



	// • === dump »
	public static function dump($dump)
	{
		exit('<pre><tt><strong style="color:#B39062;">Fio™ Framework!</strong><br/><div style="color:#7B027B; padding: 2px;">' . var_export($dump, true) . '</div></tt></pre>');
	}



	// • === kill »
	public static function kill($error, $extra = null)
	{
		$output = '';
		if (is_string($error)) {
			$message = $error;
		} elseif (is_array($error)) {
			$title = $error['title'];
			$message = $error['message'];
		}
		if (!empty($title)) {
			$output .= '<strong style="color:#B39062;">' . $title . '</strong>:';
		}
		if (!empty($message)) {
			if (!empty($extra)) {
				if (is_array($extra)) {
					$implode = implode(" • ", array_map(fn($key, $value) => "$key: $value", array_keys($extra), $extra));
					$extra = $implode;
				}
				$message .= ' ➝ [<small style="color: #A62626;"><em>' . $extra . '</em></small>]';
			}
			$output .= '<span style="color:#7B027B; padding: 2px;">' . ucfirst($message) . '</span>';
		}
		exit($output);
	}



	// • === tryCatch »
	public static function tryCatch(callable $callback, $default = null, $caller = null)
	{
		try {
			return $callback();
		} catch (Throwable $e) {

			if (!empty($default)) {
				return $default;
			}

			$extra = null;

			$exception = get_class($e);
			if (!empty($exception)) {
				$extra['type'] = $exception;
			}

			if (is_array($extra)) {
				$extra['reason'] = $e->getMessage();
			}

			return self::kill(['title' => $caller, 'message' => 'exception occurred'], $extra);
		}
	}



	// • === site » set & get
	public static function site(null|string|object|array $param = null)
	{
		// ➝ get self::$site
		if (!$param) {
			return self::$site ?? null;
		}

		// ➝ get self::$site->$param
		if (is_string($param)) {
			return isset(self::$site) && is_object(self::$site) && property_exists(self::$site, $param)	? self::$site->$param : null;
		}

		// ➝ convert $param array to object (when applicable)
		if (is_array($param)) {
			$param = (object) $param;
		}

		// ➝ set self::$site
		if (is_object($param)) {
			return self::property(['site' => $param]);
		}
	}



	// • === database » set & get
	public static function database(null|string|object|array $param = null)
	{
		if (!$param) {
			return self::$database ?? null;
		}
		if (is_string($param)) {
			return isset(self::$database) && is_object(self::$database) && property_exists(self::$database, $param)	? self::$database->$param : null;
		}
		if (is_array($param)) {
			$param = (object) $param;
		}
		if (is_object($param)) {
			return self::property(['database' => $param]);
		}
	}



	// • === input »
	public static function input()
	{
		return new oInput();
	}



	// • === dbo »
	public static function dbo()
	{
		return new oDBO();
	}



	// • === pdo »
	public static function pdo()
	{
		$dbo = new oDBO();
		$dbo::init('pdo');
		return $dbo;
	}



	// • === sqli »
	public static function sqli()
	{
		$dbo = new oDBO();
		$dbo::init('sqli');
		return $dbo;
	}



	// • === file »
	public static function file()
	{
		return new oFile();
	}



	// • === path »
	public static function path()
	{
		return new oPath();
	}



	// • === layout »
	public static function layout()
	{
		return new oLayout();
	}



	// • === asset »
	public static function asset()
	{
		return new oAsset();
	}



	// • === frontend »
	public static function frontend()
	{
		return new oFrontend();
	}



	// • === forbidden »
	public static function forbidden($file, $error = ['title' => 'Forbidden', 'message' => 'Direct access denied'])
	{
		if (self::file()->forbidden($file)) {
			header("HTTP/1.0 403 Forbidden");
			self::kill($error);
		}
		return false;
	}
}
