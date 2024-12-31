<?php

return [

	/*
	|--------------------------------------------------------------------------
	| VCS Type to create Ignore Files
	|--------------------------------------------------------------------------
	|
	| Supported systems:
	| - git
	|
	*/

	'vcs'	=> 'git',

    /*
    |--------------------------------------------------------------------------
    | Dump Output Path 
    |--------------------------------------------------------------------------
    |
    | The DB_DUMP_DIR variable specifies the name of the dump directory inside database_path.
    | You can also change the full path using the --path command-line option.
    |
    */

    'path'	=> database_path(env('DB_DUMP_DIR', 'dumps')),


    /*
    |--------------------------------------------------------------------------
    | Seed Input Directory 
    |--------------------------------------------------------------------------
    |
    | The DB_SEED_DIR variable specifies the name of the current 
    | seed source directory inside dump output path.
    |
    */

    'seed'	=> env('DB_SEED_DIR', 'data'),

    /*
    |--------------------------------------------------------------------------
    | Table Exclusions
    |--------------------------------------------------------------------------
    |
    | Ignore the dump of the specified tables
    |
    */

    'exclusions' => [
		'cache',
		'cache_locks',
		'failed_jobs',
		'job_batches',
		'jobs',
		'migrations',
		'password_reset_tokens',
		'personal_access_tokens',
		'sessions',
    ],

];
