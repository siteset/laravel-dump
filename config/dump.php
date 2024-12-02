<?php

return [

	/*
	|--------------------------------------------------------------------------
	| VCS Name
	|--------------------------------------------------------------------------
	|
	| - git
	|
	*/

	'vcs'	=> 'git',

    /*
    |--------------------------------------------------------------------------
    | Dump Output Path
    |--------------------------------------------------------------------------
    |
    | The DUMP_DIR variable specifies the name of the seed directory inside database_path.
    | You can also change the full path using the --path command-line option.
    |
    */

    'path'	=> database_path(env('DB_DUMP_DIR', 'dumps')),

    /*
    |--------------------------------------------------------------------------
    | Table Exclusions
    |--------------------------------------------------------------------------
    |
    | Ignore the dump of the specified tables
    |
    */

    'exclusions' => [
        'migrations',
        'password_resets',
    ],

];
