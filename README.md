# Laradb

[![Latest Version on Packagist](https://img.shields.io/packagist/v/ahmedsaoud31/laradb.svg?style=flat-square)](https://packagist.org/packages/ahmedsaoud31/laradb)
[![Total Downloads](https://img.shields.io/packagist/dt/ahmedsaoud31/laradb.svg?style=flat-square)](https://packagist.org/packages/ahmedsaoud31/laradb)
[![License](https://img.shields.io/packagist/l/ahmedsaoud31/laradb.svg?style=flat-square)](https://packagist.org/packages/ahmedsaoud31/laradb)

Laradb is a package to Backup and Restore data from active database and skip deleted rows in restore.

Use this package when you change database schema and you want to restore the old data to your actual database.

First backup your current database using this package and after finishing your editing just restore the database.

Some times we need to run migrate:fresh command, in this case this package will help you to restore the previous database records.


## Installation

```bash
composer require ahmedsaoud31/laradb
```

The package will automatically register its service provider.

## Usage

### Backup database

Run the Laradb console command:

```bash
php artisan laradb:backup
```

### Restore database

Run the Laradb console command:

```bash
php artisan laradb:restore
```

## License

The MIT License (MIT). Please see [License](LICENSE) for more information.
