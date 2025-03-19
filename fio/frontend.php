<?php //*** oFrontend - ... » Fio™ © 2025 ∞ OE2i™ • www.oe2i.com ∞ Apache License ***//

namespace Fio;

class oFrontend
{

	// • === title »
	public static function title(?string $title = null)
	{
		return '<title>' . Fio::site('firm') . (!empty($title) ? ' - ' . $title : '') . '</title>';
	}



	// • === image »
	public static function image(string $image)
	{
		return '<img src="' . Fio::asset()->image($image) . '">';
	}



	// • === icon »
	public static function icon(string $image)
	{
		return '<img src="' . Fio::asset()->icon($image) . '">';
	}



	// • === copyright »
	public static function copyright($reserved = true)
	{
		$o = "&copy; " . '<strong>' . date('Y') . ' ' . Fio::site('firm') . '.</strong>';
		if ($reserved === true) {
			$o .= ' All Rights Reserved.';
		}
		return $o;
	}
}
