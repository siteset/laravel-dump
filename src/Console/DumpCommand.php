<?php

namespace Siteset\Dump\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Siteset\Dump\Database\Table;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class DumpCommand extends Command
{
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */

	protected $signature = 'db:json {--path=} {--folder=} {--skip=}';

	/**
	 * The console command description.
	 *
	 * @var string
	 */

	protected $description = 'Dump the database tables with records as JSON files';

	/**
	 *
	 * @var \Carbon\Carbon
	 */

	private $date;

	/**
	 *
	 * @var string
	 */

	private $vcs;

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */

	public function __construct()
	{
		parent::__construct();

		$this->date	= now();
		$this->vcs	= '\\Facades\\Siteset\\Dump\\Vcs\\' . Str::title(config('dump.vcs', 'git'));
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */

	public function handle()
	{
		// Path to all dumps base directory
		$path	= filled($this->option('path'))	? $this->option('path')	: config('dump.path');
		$path   = Str::of($path)->finish(DIRECTORY_SEPARATOR);

		// Directory name of current dump
		$folder	= filled($this->option('folder')) ? $this->option('folder')	: 'dump_' . $this->date->format('Y-m-d_H-i-s');

		// Create base dumps directory if it's not exist
		if (! File::exists($path)) {
			File::makeDirectory($path);
		}

		// Glue the path name to current dump
		$dir = Str::of($path . $folder)->finish(DIRECTORY_SEPARATOR);

		// Read table names from schema and make dump for each of them, except excluded names
		foreach (DB::select('show tables') as $row) {
			$name = current((array)$row);

			if (in_array($name, config('dump.exclusions', []))) {
				continue;
			}

			$skip = call_user_func(function () use ($name) {
				$tables = array_map(function ($table) {
					return trim($table);
				}, (null !== $this->option('skip') ? explode(',', $this->option('skip')) : []));

				return in_array($name, $tables);
			});

			if (Table::save($dir, $name, $skip)) {
				$this->line("<info>Dump:</info> {$name}");
			}
		}

		// Create an ignore file for Version Control System
		$this->vcs::ignore($path . DIRECTORY_SEPARATOR . $folder);
	}
}
