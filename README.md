# Flarum-sendgrid

![License](https://img.shields.io/badge/license-MIT-blue.svg) [![Latest Stable Version](https://img.shields.io/packagist/v/blomstra/sendgrid.svg)](https://packagist.org/packages/blomstra/sendgrid) [![Total Downloads](https://img.shields.io/packagist/dt/blomstra/sendgrid.svg)](https://packagist.org/packages/blomstra/sendgrid)

A [Flarum](http://flarum.org) extension that adds the Sendgrid driver to the mail page and allows sendgrid to suspend users whose email is bouncing and disable user notifications for email when these users mark the email as spam.

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

## Configuration

### Select driver

Make sure to switch to the sendgrid driver on the admin Mail page.

### Set up the webhook
To allow webhook integration with SendGrid, add this to your SendGrid webhook at https://app.sendgrid.com/settings/mail_settings/webhook_settings

```
https://your-url.test/api/flarum-sendgrid/hooks/events
```

You should enable "Bounced" from Deliverability Data and "Spam Reports from Engagement Data.

## Links

- [Packagist](https://packagist.org/packages/blomstra/sendgrid)
- [GitHub](https://github.com/blomstra/flarum-ext-sendgrid)
- [Discuss](https://discuss.flarum.org/d/34595-sendgrid-mail-driver)
