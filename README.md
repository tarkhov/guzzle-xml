# Guzzle XML

Guzzle XML request.

### Contents

1. [Compatibility](#compatibility)
2. [Installation](#installation)
   1. [Composer](#composer)
3. [Usage](#usage)
   1. [Request options](#request-options)
4. [Author](#author)
5. [License](#license)

## Compatibility

Library | Version
------- | -------
Guzzle | 6.3

## Installation

### Composer

```bash
composer require tarkhov/guzzle-xml
```

## Usage

### Request options

Following example creates POST request with XML body. Option `xml` accepts an array that is converted to XML document.

```php
<?php
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Client;
use GuzzleXml\XmlMiddleware;

$stack = HandlerStack::create();
$stack->push(XmlMiddleware::xml(), 'xml');
$client = new Client(['handler' => $stack]);
$response = $client->post('https://example.com', [
  'xml' => [
    'package' => [
        '@language' => 'PHP',
        'name'      => 'Guzzle XML',
        'author'    => [
          '@role' => 'developer',
          '#'     => 'Alexander Tarkhov',
        ],
        'support'   => [
            'issues' => 'https://github.com/tarkhov/guzzle-xml/issues',
            'source' => 'https://github.com/tarkhov/guzzle-xml',
        ],
    ],
  ],
]);
```

## Author

**Alexander Tarkhov**

* [Facebook](https://www.facebook.com/alex.tarkhov)
* [Twitter](https://twitter.com/alextarkhov)
* [Medium](https://medium.com/@tarkhov)
* [Product Hunt](https://www.producthunt.com/@tarkhov)

## License

This project is licensed under the **MIT License** - see the `LICENSE` file for details.
