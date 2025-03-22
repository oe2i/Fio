<?php //*** oAsset - ... » Fio™ © 2025 ∞ OE2i™ • www.oe2i.com ∞ Apache License ***//

namespace Fio;

class oAsset
{
	// • === css »
	public static function css($css)
	{
		return '/asset/css/' . $css . '.css';
	}



	// • === js »
	public static function js($js)
	{
		return '/asset/js/' . $js . '.js';
	}



	// • === image »
	public static function image($image)
	{
		return '/asset/image/' . $image;
	}



	// • === favicon »
	public static function favicon($favicon = 'favicon.png')
	{
		return '/asset/favicon/' . $favicon;
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
