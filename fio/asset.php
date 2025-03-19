<?php //*** oAsset - ... » Fio™ © 2025 ∞ OE2i™ • www.oe2i.com ∞ Apache License ***//

namespace Fio;

class oAsset
{
	// • === image »
	public static function image($image)
	{
		return '/asset/image/' . $image;
	}



	// • === icon »
	public static function icon($image)
	{
		return self::image('icon/' . $image);
	}



	// • === video »
	public static function video($video)
	{
		return '/asset/video/' . $video;
	}
}
