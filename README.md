# Flarum-sendgrid

![License](https://img.shields.io/badge/license-MIT-blue.svg) [![Latest Stable Version](https://img.shields.io/packagist/v/blomstra/flarum-sendgrid.svg)](https://packagist.org/packages/blomstra/flarum-sendgrid) [![Total Downloads](https://img.shields.io/packagist/dt/blomstra/flarum-sendgrid.svg)](https://packagist.org/packages/blomstra/flarum-sendgrid)

A [Flarum](http://flarum.org) extension. 

## Installation

Install with composer:

```sh
composer require blomstra/sendgrid:"*"
```

## Updating

```sh
composer update blomstra/sendgrid:"*"
php flarum migrate
php flarum cache:clear
```

## Using the Webhook
To allow webhook integration with SendGrid, add this to your SendGrid webhook.

```
https://your-url.test/api/flarum-sendgrid/hooks/events
```

## Links

- [Packagist](https://packagist.org/packages/blomstra/flarum-sendgrid)
- [GitHub](https://github.com/blomstra/flarum-sendgrid)
- [Discuss](https://discuss.flarum.org/d/PUT_DISCUSS_SLUG_HERE)
