# Dump Database Tables With Records as JSON

## Installation

Add the package record to the 'require' section of the composer.json file.
```json
    "require": {
    	...,
        "siteset/laravel-dump": "^1.0@dev"
    },
```

Update the package with Composer:
```bash
composer update siteset/laravel-dump
```

## Setup

Bind command to application kernel **/app/Console/Kernel.php**

```php
protected $commands = [
    \Siteset\Dump\Console\DumpCommand::class,
];
```
Add DumpServiceProvider into **/config/app.php** 

```php
'providers' => [
    ...,
    Siteset\Dump\DumpServiceProvider::class,
    ...,
],
```

Refresh Composer Autoload

```php
composer dump-autoload
```

Renew or create configuration file (you can delete old file)

```
php artisan vendor:publish --provider="Siteset\Dump\DumpServiceProvider"
```

## Usage

Execute command **db:json** to make dump:
```
php artisan db:json
```

**JSON** dump will be created at directory **/database/dumps/dump_YYYY-MM-DD_HH-II-SS**

You can change it by options --path and --folder 