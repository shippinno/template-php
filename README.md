# PHP tool for handling text template files 

[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/shippinno/template-php/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/shippinno/template-php/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/shippinno/template-php/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/shippinno/template-php/?branch=master)
[![Build Status](https://scrutinizer-ci.com/g/shippinno/template-php/badges/build.png?b=master)](https://scrutinizer-ci.com/g/shippinno/template-php/build-status/master)

## Installation

```sh
$ composer require shippinno/template
```

## Usage

Assume that you have a [Liquid](https://shopify.github.io/liquid/) template file in the local filesystem like below.

```sh
$ tree -d /templates
/templates
|-- hello.liquid 
$ cat /templates/hello.liquid
Hello, {{ you }} !!
```

It is super easy to load that template and render with variables.

```php
use League\Flysystem\Adapter\Local;
use League\Flysystem\Filesystem;
use Shippinno\Template\Liquid;

$filesystem = new Filesystem(new Local('/templates'));
$liquid = new Liquid($filesystem);
$liquid->render('hello', ['you' => 'Shippinno']); // => 'Hello, Shippinno !!'
```

Template files can be on any “filesystem” as far as [Flysystem](http://flysystem.thephpleague.com/docs/) supports it.

```php
use Spatie\Dropbox\Client;
use Spatie\FlysystemDropbox\DropboxAdapter;

$client = new Client('AUTH_TOKEN');
$filesystem = new Filesystem(new DropboxAdapter($client));
$liquid = new Liquid($filesystem);
// ...
```

Or you can also just render with a template source.

```
$twig = new Twig;
$twig->renderSource('Hello, {{ you }} !!', ['you' => 'Shipiinno']); // => 'Hello, Shippinno !!'
```

