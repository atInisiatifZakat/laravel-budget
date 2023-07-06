# Laravel Budget

[![PHPUnit](https://github.com/atInisiatifZakat/laravel-budget/actions/workflows/run-tests.yml/badge.svg?branch=main)](https://github.com/atInisiatifZakat/laravel-budget/actions/workflows/run-tests.yml)
[![Psalm](https://github.com/atInisiatifZakat/laravel-budget/actions/workflows/run-psalm-static-analyst.yml/badge.svg?branch=main)](https://github.com/atInisiatifZakat/laravel-budget/actions/workflows/run-psalm-static-analyst.yml)
[![Laravel Pint](https://github.com/atInisiatifZakat/laravel-budget/actions/workflows/fix-php-code-style-issues.yml/badge.svg)](https://github.com/atInisiatifZakat/laravel-budget/actions/workflows/fix-php-code-style-issues.yml)
[![Latest Version on Packagist](https://img.shields.io/packagist/v/inisiatif/laravel-budget.svg?style=flat-square)](https://packagist.org/packages/inisiatif/laravel-budget)
[![Total Downloads](https://img.shields.io/packagist/dt/inisiatif/laravel-budget.svg?style=flat-square)](https://packagist.org/packages/inisiatif/laravel-budget)

Package yang di gunakan internal di Inisiatif Zakat Indonesia untuk mengakses anggaran tahunan.

> Versi laravel yang digunakan adala ^9.43 atau ^10.0

## Installation

Anda dapat menginstall menggunakan composer

```bash
composer require inisiatif/laravel-budget
```

Jika diperlukan anda bisa mempublish file migrasi dan menjalankannya dengan perintah

```bash
php artisan vendor:publish --tag="laravel-budget-migrations"
php artisan migrate
```

Anda juga bisa mempublish file konfigurasi dengan perintah

```bash
php artisan vendor:publish --tag="laravel-budget-config"
```

Ini adalah isi dari file konfigurasi yang di publish :

```php
return [
    /**
     * This is connection database must be available in database config
     */
    'connection' => env('LARAVEL_BUDGET_ELOQUENT_CONNECTION', env('DB_CONNECTION', 'sqlite')),

    /**
     * This is table name for budget
     */
    'table' => env('LARAVEL_BUDGET_ELOQUENT_TABLE', 'budgets'),

    /**
     * Indicated must be running migration, internally used in testing
     */
    'migration' => env('LARAVEL_BUDGET_ELOQUENT_MIGRATION', false),

    /**
     * Column name mapping, you can change this value is column name is different
     */
    'columns' => [
        'id' => 'id',
        'code' => 'code',
        'description' => 'description',
        'total_amount' => 'total_amount',
        'usage_amount' => 'usage_amount',
        'is_over' => 'is_over',
    ],

    /**
     * Column version name, for json type fill using json path, ex : `version->year`
     */
    'version_column_name' => 'year',

    /**
     * Column type for version column
     *
     * Support: int, string, json
     */
    'version_column_type' => 'int',

    /**
     * Disable or enable timestamps in model
     */
    'model_uses_timestamps' => true,
];

```

## Penggunaan

### Model

Librari ini mempublish beberapa konfigurasi terkait dengan model budget yang digunakan.

Default model yang digunakan adalah `Inisiatif\LaravelBudget\Models\Budget`, apabila ingin
menggunakan model yang lain, anda harus mendaftarkannya di method `boot` pada `AppServiceProvider`

```php
use Inisiatif\LaravelBudget\LaravelBudget;

LaravelBudget::useBudgetModelClass('Acme\Models\Budget');
```

> Pastikan model yang kamu buat merupakah child dari `Inisiatif\LaravelBudget\Models\BudgetModel`

Selain bisa menggunakan model sendiri, librari juga memungkinkan anda untuk mengubah beberapa pengaturan terkait dengan tabel

#### Koneksi Database

Koneksi database yang digunakan dapat di ubah dengan menggunakan env `LARAVEL_BUDGET_ELOQUENT_CONNECTION`
secara default value ini mengambil dari `default` konfigurasi database.

> Kamu harus memastikan bahwa nama koneksi yang digunakan tersedia di `config/database.php`

### Tabel

Secara default, nama tabel yang digunakan adalah `budgets` sesuai dengan konvensi Laravel.
Kamu dapat mengesuaikan nama table dengan menggunakan env `LARAVEL_BUDGET_ELOQUENT_TABLE`

Selain nama tabel anda juga bisa melakukan mapping kolom yang digunakan, dengan mengubah konfigurasi

```php
'columns' => [
    'id' => 'id',
    'code' => 'code',
    'description' => 'description',
    'total_amount' => 'total_amount',
    'usage_amount' => 'usage_amount',
    'is_over' => 'is_over',
],
```

Lebih lengkat terkait konfigurasi anda bisa melihat file konfigurasi yang ada.

### Rest API

Librari ini menyediakan beberapa end point Rest API, sebelumnya anda harus mendaftarkan route di `routes/api.php`

```php
// File routes/api.php

use Inisiatif\LaravelBudget\LaravelBudget;

LaravelBudget::routes();
```

1. Mengeluarkan list budget

    ```text
    GET /api/budget
    GET /api/budget?version=2023
    GET /api/budget?code=CODE001
    GET /api/budget?description=Foo
    ```
   
    Anda dapat menambahkan parameter `limit` untuk menambah jumlah data yang di keluarkan, default value adalah `15`


2. Mengeluarkan current versioni budget, version biasanya berdasarkan tahun

    ```text
    GET /api/budget/current
    GET /api/budget/current?code=CODE001
    GET /api/budget/current?description=Foo
    ```
   Anda dapat menambahkan parameter `limit` untuk menambah jumlah data yang di keluarkan, default value adalah `15`

3. Menampilakn satu budget menggunakan `code` atau `id`

    ```text
    GET /api/budget/CODE001
    GET /api/budget/1
   ```

Object json yang di munculkan adalah

```json
{
    "id": 1,
    "code": "CODE001",
    "description": "Anggaran pengembangan aplikasi",
    "total_amount": 100000000.00,
    "usage_amount": 0.00,
    "balance_amount": 100000000.00,
    "is_over": false,
    "is_limit_reached": false
}
```

### Saldo Anggaran

Librari ini juga menyediakan cara untuk merubah balance dengan cara menambah dan mengurasi `usage`

```php
// Sebelumnya anda harus menganbil budget dari database

$budget->increaseUsage(1000); // Untuk menambah penggunaan anggaran sebanyak 1000
$budget->decreaseUsage(500); // Untuk mengurasi penggunaan anggaran sebanyak 500
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Nuradiyana](https://github.com/atInisiatifZakat)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
