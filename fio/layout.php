<?php //*** oLayout - ... » Fio™ © 2025 ∞ OE2i™ • www.oe2i.com ∞ Apache License ***//

namespace Fio;

class oLayout
{
	// • === piece »
	public static function piece($file, $path = null)
	{
		return oInc::piece(file: $file, path: $path);
	}



	// • === slice »
	public static function slice($file)
	{
		return oInc::slice($file);
	}



	// • === head »
	public static function head($file = 'head', $title = null)
	{
		return oInc::slice($file, ['title' => $title]);
	}



	// • === header »
	public static function header($file = 'header')
	{
		return oInc::slice($file);
	}



	// • === nav »
	public static function nav($file = 'navigation')
	{
		if ($file === 'navigation') {
			return oInc::slice($file);
		} else {
			return oInc::slice('nav' . Fio::property('DS') . $file);
		}
	}



	// • === footer »
	public static function footer($file = 'footer', $vars = null)
	{
		// // if (is_string($vars)) {
		// // 	$vars = compact($vars);
		// // }
		// Fio::dump($vars);
		return oInc::slice($file, $vars);
	}
}
