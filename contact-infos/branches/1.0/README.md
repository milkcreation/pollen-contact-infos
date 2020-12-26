# Contact Infos Component

[![Latest Version](https://img.shields.io/badge/release-1.0.0-blue?style=for-the-badge)](https://www.presstify.com/pollen-solutions/contact-infos/)
[![MIT Licensed](https://img.shields.io/badge/license-MIT-green?style=for-the-badge)](LICENSE.md)

**Contact Infos** makes it easy to store and view contact information.

## Installation

```bash
composer require pollen-solutions/contact-infos
```

## Pollen Framework Setup

### Declaration

```php
// config/app.php
return [
      //...
      'providers' => [
          //...
          \Pollen\ContactInfos\ContactInfosServiceProvider::class,
          //...
      ];
      // ...
];
```

### Configuration

```php
// config/contact-infos.php
// @see /vendor/pollen-solutions/contact-infos/resources/config/contact-infos.php
return [
      //...

      // ...
];
```
