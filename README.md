# Guzzle XML

Guzzle XML request and response.

### Contents

1. [Compatibility](#compatibility)
2. [Installation](#installation)
   1. [Composer](#composer)
3. [Usage](#usage)
   1. [Request options](#request-options)
   2. [Response](#response)
4. [Author](#author)
5. [License](#license)

## Compatibility

Library | Version
------- | -------
PHP | >=5.5.9 and < 7.0 or >=7.0.8
Guzzle | >=6.0 and < 7.0
Symfony Serializer | >= 3.4 and < 4.0

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

### Response

Convert your JSON response to XML using middleware.

```php
<?php
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Client;
use GuzzleXml\XmlMiddleware;

$stack = HandlerStack::create();
$stack->push(XmlMiddleware::jsonToXml());
$client = new Client(['handler' => $stack]);
$response = $client->post('https://example.com');
$xml = $response->getBody();
echo $xml;
```

## Author

**Alexander Tarkhov**

* [Twitter](https://twitter.com/alextarkhov)
* [Medium](https://medium.com/@tarkhov)
* [LinkedIn](https://www.linkedin.com/in/tarkhov/)
* [Facebook](https://www.facebook.com/alextarkhov)

## License

This project is licensed under the **MIT License** - see the `LICENSE` file for details.
