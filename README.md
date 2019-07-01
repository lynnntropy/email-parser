# email-parser

[![Build Status](https://travis-ci.org/omegavesko/email-parser.svg?branch=master)](https://travis-ci.org/omegavesko/email-parser)

`email-parser` is a PHP library that makes it easy to get various information 
about a given email address.

## Getting Started

### Prerequisites

- PHP >= 7.2
- [Composer](https://getcomposer.org/)

### Installing

```bash
composer require omegavesko/email-parser
```

### Usage

To use the parser, create an instance of the `EmailParser` class, and use the 
`parseEmail()` and `parseEmails()` methods to parse emails into `EmailInformation` 
instances.

```php
<?php

use OmegaVesko\EmailParser\EmailParser;

$parser = new EmailParser();

$emailInformation = $parser->parseEmail('example@test.dev');

$emailInformation->getEmail(); // 'example@test.dev'
$emailInformation->getDomain(); //  'test.dev'
$emailInformation->getLocalPart(); // 'example'
$emailInformation->getEmailService(); // EmailServiceInformation instance (or null)

```

## Running the tests

```bash
vendor/bin/phpunit
```

## Authors

* **Veselin Romić (omegavesko@gmail.com)**

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) 
file for details.
