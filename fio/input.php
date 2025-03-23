<?php //*** oInput - ... » Fio™ © 2025 ∞ OE2i™ • www.oe2i.com ∞ Apache License ***//

namespace Fio;

class oInput
{
	// • === post »
	public static function post($field)
	{
		$value = filter_input(INPUT_POST, $field, FILTER_SANITIZE_SPECIAL_CHARS);
		return $value !== null ? trim($value) : null;
	}




	// • === get »
	public static function get($field)
	{
		$value = filter_input(INPUT_GET, $field, FILTER_SANITIZE_SPECIAL_CHARS);
		return $value !== null ? trim($value) : null;
	}
}
