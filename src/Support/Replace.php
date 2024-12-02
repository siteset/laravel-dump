<?php

namespace Siteset\Dump\Support;

use Illuminate\Support\Facades\File;

class Replace
{
	/**
	 * Create a file
	 *
	 * @param string $stub
	 * @param array $variables
	 */

	public function generator($stub, $variables = null)
	{
		$file = File::get($stub);

		if (null !== $variables)
			foreach ($variables as $variable => $value)
				$file = str_replace($variable, $value, $file);

		return $file;
	}
}
