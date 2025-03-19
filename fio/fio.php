<?php //*** Fio » Fio™ © 2025 ∞ OE2i™ • www.oe2i.com ∞ Apache License ***//

namespace Fio;

class Fio
{
	// • property
	private static bool $init = false;
	protected static string $DS;
	protected static string $PS;
	protected static string $RD;



	// • === init »
	public static function init(array $prop)
	{
		if (!self::$init) {
			if (isset($prop['RD'])) {
				self::$RD = $prop['RD'];
			}
			self::$DS = DIRECTORY_SEPARATOR;
			self::$PS = '/';
			self::$init = true;
		}
	}


	// • === dump »
	public static function dump($var)
	{
		exit('<pre><tt><strong style="color:#B39062;">Fio™ Framework!</strong><br/><div style="color:#7B027B; padding: 2px;">' . var_export($var, true) . '</div></tt></pre>');
	}



	// • === kill »
	public static function kill($error)
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
			$output .= '<span style="color:#7B027B; padding: 2px;">' . $message . '</span>';
		}
		exit($output);
	}



	// • === file »
	public static function file()
	{
		return new oFile();
	}



	// • === layout »
	public static function layout()
	{
		return new oLayout();
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
