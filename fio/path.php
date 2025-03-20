<?php //*** oPath - ... » Fio™ © 2025 ∞ OE2i™ • www.oe2i.com ∞ Apache License ***//

namespace Fio;

class oPath
{
	// • property
	private static bool $init = false;


	// • === source »
	public static function source()
	{
		return Fio::property('RD') . Fio::property('DS');
	}



	// • === layout »
	public static function layout()
	{
		return self::source() . 'layout' . Fio::property('DS');
	}



	// • === piece »
	public static function piece($path = null)
	{
		if (empty($path)) {
			$path = self::layout();
		} else {
			$path = self::source() . $path;
		}
		return $path . 'piece' . Fio::property('DS');
	}



	// • === slice »
	public static function slice()
	{
		return self::layout() . 'slice' . Fio::property('DS');
	}
}
