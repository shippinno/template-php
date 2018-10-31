# PHP tool for handling text template files 

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
use Shippinno\Template\LiquidTemplateLoader;

$filesystem = new Filesystem(new Local('/templates'));
$templateLoader = new LiquidTemplateLoader($filesystem);
$template = $templateLoader->load('hello');

$template->render(['you' => 'Shippinno']); // => Hello, Shippinno !!
```

Template files can be on any “filesystems” as far as [Flysystem](http://flysystem.thephpleague.com/docs/) supports it.

```php
use Spatie\Dropbox\Client;
use Spatie\FlysystemDropbox\DropboxAdapter;

$client = new Client('AUTH_TOKEN');
$filesystem = new Filesystem(new DropboxAdapter($client));
$templateLoader = new LiquidTemplateLoader($filesystem);
```