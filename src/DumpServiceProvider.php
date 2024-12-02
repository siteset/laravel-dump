<?php

namespace Siteset\Dump;

use Illuminate\Support\ServiceProvider;

class DumpServiceProvider extends ServiceProvider
{
	/**
	 *
	 * @return void
	 */

	public function register() //: void
	{
		$this->publishes([
			__DIR__ . '/../config/dump.php' => config_path('dump.php')
		], 'config');
	}

	/**
	 *
	 * @return void
	 */

	public function boot() //: void
	{
		//
	}
}
