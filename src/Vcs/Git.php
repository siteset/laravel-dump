<?php

namespace Siteset\Dump\Vcs;

use Illuminate\Support\Facades\File;
use Facades\Siteset\Dump\Support\Replace;

class Git implements \Siteset\Dump\Contracts\Vcs
{
	/**
	 * Create a ignore file for version control system
	 * (used git by default)
	 *
	 * @param string $path
	 */

	public function ignore($path)
	{
		// Directory absent
		if (!File::exists("{$path}"))
			return;

		// File present
		if (File::exists("{$path}/.gitignore"))
			return;

		// Writing the contents of the ignore file
		File::put(
			"{$path}/.gitignore",
			Replace::generator(
				__DIR__ . '/../stubs/.gitignore.stub'
			)
		);
	}
}
