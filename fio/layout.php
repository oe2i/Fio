<?php //*** oLayout - ... » Fio™ © 2025 ∞ OE2i™ • www.oe2i.com ∞ Apache License ***//

namespace Fio;

class oLayout
{
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
			$file = oInc::slice($file);
		} else {
			$file = oInc::slice('nav' . Fio::property('DS') . $file);
		}
		return $file;
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
