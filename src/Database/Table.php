<?php

namespace Siteset\Dump\Database;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class Table
{
	/**
	 * Table Name
	 *
	 * @var string
	 */

	public $name;

	/**
	 * Table Fields List
	 *
	 * @var array
	 */

	public $fields = [];

	/**
	 * Offset
	 *
	 * @var integer
	 */

	private $offset = 0;

	/**
	 * Limit
	 *
	 * @var integer
	 */

	private $limit = 1000;

	/**
	 * Save Records
	 *
	 * @return boolean
	 *
	 * @param string $path
	 * @param string $name
	 * @param boolean $skip
	 */

	public static function save($path, $name, $skip = false)
	{
		$table = new Table($name);

		// Create dump directory
		if (! File::exists($path)) {
			File::makeDirectory($path);
		}

		// Delete existing dump
		if (File::exists("{$path}/{$table->name}.json")) {
			File::delete("{$path}/{$table->name}.json");
		}

		// Skipping table data
		if (true === $skip) {
			// Write an empty file
			File::put("{$path}/{$table->name}.json", '[]');
		}

		// Formatted data
		elseif (false === env('DB_DUMP_MINIFY', false)) {
			// Write the initial bracket
			File::put("{$path}/{$table->name}.json", '[');

			// Fetch bunch of records (by $this->limit amount)
			$first = true;
			while ($records = $table->records())
				// Scroll records in the bunch
				foreach ($records as $record) {
					$data = call_user_func(function () use ($first, $table, $record) {
						$str = (true === $first ? '' : ',') . PHP_EOL . "\t{";

						foreach ($table->fields as $key => $field) {
							$name = $field->name;
							$str .= ($key === 0 ? '' : ',') . PHP_EOL . "\t\t\"{$name}\":" . json_encode($record->$name, JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES);
						}

						return $str . PHP_EOL . "\t}";
					});

					File::append("{$path}/{$table->name}.json", $data);

					$first = false;
				}

			// Write the final bracket
			File::append("{$path}/{$table->name}.json", (true === $first ? '' : PHP_EOL ) . "]");
		}

		// Minified data
		else {
			// Write the initial bracket
			File::put("{$path}/{$table->name}.json", '[');

			// Fetch bunch of records (by $this->limit amount)
			$first = true;
			while ($records = $table->records())
				// Scroll records in the bunch
				foreach ($records as $record) {
					$data = call_user_func(
						function () use ($table, $record) {
							$row = [];

							foreach ($table->fields as $field) {
								$name		= $field->name;
								$row[$name]	= $record->$name;
							}

							return $row;
						}
					);

					// Write a data block
					File::append(
						"{$path}/{$table->name}.json",
						(true === $first ? '' : ',') . json_encode(
							$data,
							 JSON_UNESCAPED_UNICODE
							|JSON_UNESCAPED_SLASHES
						)
					);

					$first = false;
				}

			// Write the final bracket
			File::append("{$path}/{$table->name}.json", ']');
		}

		return true;
	}

	/**
	 * Constructor
	 *
	 * @param string $name
	 */

	public function __construct($name)
	{
		// Set name of table
		$this->name = $name;

		// Get fields of table
		$this->fields();
	}

	/**
	 * Get bunch of records
	 *
	 */

	public function records()
	{
		$records = DB::table($this->name)
			->skip($this->offset * $this->limit)
			->take($this->limit)
			->get();

		if (! $records->count()) {
			$this->offset = 0;
			return false;
		}

		$this->offset++;

		return $records;
	}

	/**
	 * Get list of fields
	 *
	 */

	private function fields()
	{
		foreach (DB::select("show columns from `{$this->name}`") as $field) {
			$this->fields[] = new Field($field->Field);
		}
	}
}
