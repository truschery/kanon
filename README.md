# JSON Canonicalization Scheme (RFC 8785) for PHP

[![Latest Version on Packagist](https://img.shields.io/packagist/v/truschery/kanon.svg?style=flat-square)](https://packagist.org/packages/truschery/kanon)
[![PHP from Packagist](https://img.shields.io/packagist/php-v/truschery/kanon.svg?style=flat-square)](https://packagist.org/packages/truschery/kanon)
[![Total Downloads](https://img.shields.io/packagist/dt/truschery/kanon.svg?style=flat-square)](https://packagist.org/packages/truschery/kanon)
[![Tests](https://img.shields.io/github/actions/workflow/status/truschery/kanon/tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/truschery/kanon/actions)
[![License](https://img.shields.io/packagist/l/truschery/kanon.svg?style=flat-square)](https://packagist.org/packages/truschery/kanon)

A lightweight and strict PHP implementation of the **JSON Canonicalization Scheme (JCS)** according to [RFC 8785](https://datatracker.ietf.org/doc/html/rfc8785).

## About the Specification

JSON Canonicalization Scheme (RFC 8785) defines a standard way to serialize JSON data so that logically equivalent data produces identical byte-by-byte output. This is essential for creating digital signatures, hashing JSON payloads, or safely comparing JSON documents.

Key rules of JCS:
- Object properties are sorted lexicographically by their byte values.
- Whitespace between tokens is removed.
- Numbers are serialized in a strict format without trailing zeros.

## ⚠️ Important Note (PHP Configuration)

For this package to correctly serialize floating-point numbers according to the RFC requirements, your `php.ini` must have the `serialize_precision` directive set to `-1`.

Check your `php.ini` file:
```ini
serialize_precision = -1
```
*Note: In modern PHP versions (7.1+), `-1` is usually the default value, which ensures floats are encoded accurately.*

## Installation

You can install the package via Composer:

```bash
composer require truschery/kanon
```

## Usage

Pass your array or object to the canonicalizer to get the RFC 8785 compliant JSON string.

```php
use Truschery\Kanon\Json;

// Unordered array with different data types
$data =[
    'z' => 123.456,
    'a' => 'test',
    'b' =>[
        'foo' => 'bar',
        'baz' => 100
    ]
];

$canonicalJson = Json::canonicalize($data);

echo $canonicalJson;
// Output (keys sorted, no spaces):
// {"a":"test","b":{"baz":100,"foo":"bar"},"z":123.456}
```

## Testing

This package comes with a test suite to ensure strict compliance with the specification. To run the tests, use:

```bash
composer test
# or directly:
./vendor/bin/phpunit
```

## References

- [RFC 8785: JSON Canonicalization Scheme (JCS)](https://datatracker.ietf.org/doc/html/rfc8785)

## License

The MIT License (MIT). Please see [License File](LICENSE) for more information.