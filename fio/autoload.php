<?php //*** Autoload - ... » Fio™ © 2025 ∞ OE2i™ • www.oe2i.com ∞ Apache License ***//

if (session_status() !== PHP_SESSION_ACTIVE) {
	session_start();
}

class Autoload
{

	// • === construct »
	public function __construct()
	{
		$this->fio();
	}



	// • === fio »
	private function fio()
	{
		$directory = __DIR__;
		foreach (glob($directory . '/*.php') as $file) {
			if (basename($file) !== basename(__FILE__)) {
				require_once $file;
			}
		}
	}
}


// » Initialize Autoload
new Autoload();
