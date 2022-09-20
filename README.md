# Generate Database Schema Documentation

[![Latest Version on Packagist](https://img.shields.io/packagist/v/bekwoh/laravel-db-doc.svg?style=flat-square)](https://packagist.org/packages/bekwoh/laravel-db-doc)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/bekwoh/laravel-db-doc/run-tests?label=tests)](https://github.com/bekwoh/laravel-db-doc/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/workflow/status/bekwoh/laravel-db-doc/Fix%20PHP%20code%20style%20issues?label=code%20style)](https://github.com/bekwoh/laravel-db-doc/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/bekwoh/laravel-db-doc.svg?style=flat-square)](https://packagist.org/packages/bekwoh/laravel-db-doc)

A package to provide you easy way to generate Markdown / JSON format of database schema. Viewable in non-production environment at your `http://domain.com/doc/db-schema`.

<p align="center">
  <img src="screenshot.png" />
</p>

## Installation

You can install the package via composer:

```bash
composer require bekwoh/laravel-db-doc
```

You can publish and run the migrations with:

```bash
php artisan vendor:publish --tag="laravel-db-doc-migrations"
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="laravel-db-doc-config"
```

Optionally, you can publish the views using

```bash
php artisan vendor:publish --tag="laravel-db-doc-views"
```

## Usage

To generate database schema in Markdown format:

```php
php artisan db:schema 
```

To generate database schema in JSON format:

```php
php artisan db:schema --format=json
```

To generate database schema for specific connection:

```php
php artisan db:schema --database=sqlite
```

To generate output to specific storage, add in `.env`:

```bash
LARAVEL_DB_DOC_MARKDOWN_DISK=s3
LARAVEL_DB_DOC_JSON_DISK=s3
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Nasrul Hazim Bin Mohamad](https://github.com/nasrulhazim)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
