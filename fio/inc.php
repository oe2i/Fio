<?php //*** oInc - ... » Fio™ © 2025 ∞ OE2i™ • www.oe2i.com ∞ Apache License ***//

namespace Fio;

class oInc
{

	// • === load »
	public static function load($file, $spec = 'File', string|array|null $vars = null)
	{
		if (!is_file($file)) {
			Fio::kill(['title' => $spec, 'message' => 'not found!'], $file);
		}
		// if (is_string($vars)) {
		// 	// $ven = $vars;
		// 	$vars = compact('vars');
		// }
		if (is_array($vars)) {
			extract($vars);
		}
		global $fio;
		require($file);
	}



	// • === piece »
	public static function piece($file, $path = null, $vars = null)
	{
		$file = oPath::piece($path) . $file . '.php';
		return self::load($file, 'Piece', $vars);
	}



	// • === slice »
	public static function slice($file, $vars = null)
	{
		$file = oPath::slice() . $file . '.php';
		return self::load($file, 'Slice', $vars);
	}
}
