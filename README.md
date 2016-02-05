# Laravel 5 Trello API wrapper

[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/gregoriohc/laravel-trello/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/gregoriohc/laravel-trello/?branch=master)

A simple Laravel 5 package that wraps [Trello](https://trello.com) API.

## Requirements

* PHP 5.4 or greater

## Installation

You can install the package using the [Composer](https://getcomposer.org/) package manager running this command in your project root:

```sh
composer require gregoriohc/laravel-trello
```

## Laravel

The package includes a service providers and a facade for easy integration and a nice syntax for Laravel.

Firstly, add the `Gregoriohc\LaravelTrello\TrelloServiceProvider` provider to the providers array in `config/app.php`

```php
'providers' => [
  ...
  Gregoriohc\LaravelTrello\TrelloServiceProvider::class,
],
```

and then add the facade to your `aliases` array

```php
'aliases' => [
  ...
  'Trello' => Gregoriohc\LaravelTrello\Facades\Wrapper::class,
],
```

### Configuration

Publish the configuration file with:

```sh
php artisan vendor:publish --provider="Gregoriohc\LaravelTrello\TrelloServiceProvider"
```

Head into the file and configure the keys and defaults you'd like the package to use.

## Usage

#### Creating a basic card

```php
$card = Trello::manager()->getCard();
$card
    ->setBoardId(Trello::getDefaultBoardId())
    ->setListId(Trello::getDefaultListId())
    ->setName('Example card')
    ->setDescription('Description of the card')
    ->save();
```

#### Creating a more complex card

```php
// Create the card
$card = Trello::manager()->getCard();
$card
    ->setBoardId(Trello::getDefaultBoardId())
    ->setListId(Trello::getDefaultListId())
    ->setName('Example card')
    ->setDescription('Description of the card')
    ->save();

// Add a checklist with one item
$checklist = Trello::manager()->getChecklist();
$checklist
    ->setCard($card)
    ->setName('Example list')
    ->save();
Trello::checklist()->items()->create($checklist->getId(), 'Example checklist item');

// Attach an image using a url
Trello::card()->attachments()->create($card->getId(), ['url' => 'http://lorempixel.com/400/200/']);
```

#### More examples

For more examples of usage, please see the original PHP Trello API package documentation: https://github.com/cdaguerre/php-trello-api

## Contributing

If you're having problems, spot a bug, or have a feature suggestion, please log and issue on Github. If you'd like to have a crack yourself, fork the package and make a pull request.
