<?php

namespace Siteset\Dump\Contracts;

interface Vcs
{
	/**
	 * The method should create a ignore file for Version Control System
	 *
	 * @param string $path
	 */

	public function ignore($path);
}
