# email-parser

[![Build Status](https://travis-ci.org/omegavesko/email-parser.svg?branch=master)](https://travis-ci.org/omegavesko/email-parser)
[![Maintainability](https://api.codeclimate.com/v1/badges/f49d82f0fda12e94536a/maintainability)](https://codeclimate.com/github/omegavesko/email-parser/maintainability)
[![Test Coverage](https://api.codeclimate.com/v1/badges/f49d82f0fda12e94536a/test_coverage)](https://codeclimate.com/github/omegavesko/email-parser/test_coverage)
[![Packagist Version](https://img.shields.io/packagist/v/omegavesko/email-parser.svg)](https://packagist.org/packages/omegavesko/email-parser)
[![Packagist](https://img.shields.io/packagist/dm/omegavesko/email-parser.svg)](https://packagist.org/packages/omegavesko/email-parser)
![GitHub](https://img.shields.io/github/license/omegavesko/email-parser.svg)

`email-parser` is a PHP library that makes it easy to get various information 
about an email address.

## Features

- ✔️ Configurable email validation (powered by [egulias/email-validator](https://github.com/egulias/EmailValidator))
- 🔍 Separate an email address into its segments
- 🌎 Get information about the email provider, based on the domain

## Getting Started

### Prerequisites

- PHP >= 7.2
- [Composer](https://getcomposer.org/)

### Installing

```bash
composer require omegavesko/email-parser
```

## Usage

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

### Getting email provider information

If an email uses the domain of a recognized popular public email provider
(e.g. Gmail), `email-parser` will give you its name, the domains it knows about,
and a URL to the service's webmail interface.

One particularly useful application of this feature is linking a user directly
to their email inbox, if, for example, you want to make it as easy as possible
for them to get to an email you've just sent them.

```php
<?php

use OmegaVesko\EmailParser\EmailParser;

$parser = new EmailParser();

$emailInformation = $parser->parseEmail('example@gmail.com');

$emailInformation->getEmailService()->getName(); // 'Gmail'
$emailInformation->getEmailService()->getDomains(); // ['gmail.com', 'googlemail.com']
$emailInformation->getEmailService()->getWebmailUrl(); // 'https://mail.google.com/'
```

If the email isn't from a public email provider, or one `email-parser` doesn't 
recognize, `getEmailService()` will return `null`.

### Configuration

While `email-parser` works perfectly fine out of the box with zero configuration,
there's a few things you can configure to better integrate it into your codebase,
or to adapt it to your needs. 

The `EmailParser` constructor takes the following optional arguments:

- `$logger`: An instance of `Psr\Log\LoggerInterface`. `email-parser` will use this to log
  things like non-fatal warnings.  
- `$emailValidation`: An instance of `Egulias\EmailValidator\Validation\EmailValidation`.
  `email-parser` will use this validation to validate all emails it parses. See the
  [EmailValidator docs](https://github.com/egulias/EmailValidator#available-validations)
  for available validations. 
  
  If left blank, a simple `RFCValidation` will be used as
  a sane default.


## Development 
### Running the tests

```bash
vendor/bin/phpunit
```

## Authors

* **Veselin Romić (omegavesko@gmail.com)**

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) 
file for details.
