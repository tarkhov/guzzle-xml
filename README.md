# Guzzle XML

Guzzle XML request.

### Contents

1. [Installation](#installation)
  1. [Composer](#composer)
2. [Usage](#usage)
  1. [Request options](#request-options)
3. [Author](#author)
4. [License](#license)

## Installation

### Composer

```bash
composer require tarkhov/guzzle-xml
```

## Usage

### Request options

```php
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Client;
use GuzzleXml\Middleware;

$stack = HandlerStack::create();
$stack->push(Middleware::xml(), 'xml');
$client = new Client(['handler' => $stack]);
$response = $client->post('url', [
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
            'source' => 'https://github.com/tarkhov/guzzle-xml/issues',
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
