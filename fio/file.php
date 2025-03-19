<?php //*** oFile - ... » Fio™ © 2025 ∞ OE2i™ • www.oe2i.com ∞ Apache License ***//

namespace Fio;

class oFile
{

	// • === path »
	public static function path($file, $real = false)
	{
		if ($real === true) {
			return realpath($file);
		}
	}


	// • === forbidden »
	public static function forbidden($file)
	{
		$file = self::path($file, true);
		$script = self::path($_SERVER['SCRIPT_FILENAME'], true);
		return $file === $script;
	}
}
