# Very short description of the package

[![Latest Version on Packagist](https://img.shields.io/packagist/v/kangangga/starsender.svg?style=flat-square)](https://packagist.org/packages/kangangga/starsender)
[![Total Downloads](https://img.shields.io/packagist/dt/kangangga/starsender.svg?style=flat-square)](https://packagist.org/packages/kangangga/starsender)
![GitHub Actions](https://github.com/kangangga/starsender/actions/workflows/main.yml/badge.svg)

This is where your description should go. Try and limit it to a paragraph or two, and maybe throw in a mention of what PSRs you support to avoid any confusion with users and contributors.

## Installation

You can install the package via composer:

```bash
composer require kangangga/starsender

php artisan vendor:publish --provider="Kangangga\Starsender\StarsenderServiceProvider" --tag=config

```

## Contoh Response

```json
{
    "data" => "Array",
    "status" => "Boolean",
    "message" => "String",
}
```

### Kirim Pesan Text (API Support V1/V2)

#### untuk mengirim pesan yang isinya hanya Text (Terjadwal)

#### https://starsender.online/rest-api#item-2-4

```php
Starsender::sendText([
    'phone' => '083162xxxxxx',
    'message' => 'sendButton',
    'timetable' => '2022-01-10 10:00:00' // opsional V2 Only!!
])->json();
```

### Detail Device (API Support V1/V2)

#### Untuk mengambil semua detail device yang ada di akun anda seperti nama device, device id, qr code, status, server id, dll

#### https://starsender.online/rest-api#item-3-8

```php
Starsender::getDevice()->json();
```

### Relog Device

#### Untuk merelog device yang dalam case tertentu, contoh : device macet tidak bisa kirim pesan

#### https://starsender.online/rest-api#item-3-9

```php
Starsender::relogDevice()->json();
```

### Ambil List Group

#### Untuk mengambil semua list group kontak yang ada di akun anda

#### https://starsender.online/rest-api#item-3-10

```php
Starsender::getListGroup()->json();
```

### Send Message Button

#### https://starsender.online/rest-api#item-2-7

```php
Starsender::sendButton([
    'button' => [
        'Tanya Saya',
        'Tanya Anda'
    ],
    'phone' => '083162xxxxxx',
    'message' => 'sendButton',
])->json();
```

### Kirim File Dengan Upload (API Support V1/V2)

#### untuk mengirim pesan yang berisi file atau gambar (Terjadwal)

#### https://starsender.online/rest-api#item-2-6

```php
Starsender::sendFilesUpload([
    'file' => storage_path('app/image.png'),
    'phone' => '083162xxxxxx',
    'message' => 'sendFilesUpload',
])->json();
```

### Kirim File Dengan URL (API Support V1/V2)

#### untuk mengirim pesan yang berisi file atau gambar (Terjadwal)

#### https://starsender.online/rest-api#item-2-5

```php
Starsender::sendFilesUrl([
    'file_url' => 'https://example.com/img.png',
    'phone' => '083162xxxxxx',
    'message' => 'sendFilesUrl',
])->json();
```

### Custome request endpoint

```php
Starsender::request('/v2/sendText',[
    'phone' => '083162xxxxxx',
    'message' => 'Custome request endpoint',
])->json();
```

### Testing

```bash
composer test
```

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security

If you discover any security related issues, please email masangga.com@gmail.com instead of using the issue tracker.

## Credits

-   [Angga Saputra](https://github.com/kangangga)
-   [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

## Laravel Package Boilerplate

This package was generated using the [Laravel Package Boilerplate](https://laravelpackageboilerplate.com).
