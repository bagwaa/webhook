# Webhook

> Webhook is a Statamic addon that does something pretty neat.

## Features

This addon does:

- This
- And this
- And even this

## How to Install

Require the package using composer.

``` bash
composer require bagwaa/webhook
```

Publish the configuration file using the following command in the root of your project, this is needed to configure the addon.

``` bash
php artisan vendor:publish --tag=bagwaa\webhook
```

```

## How to Use

In your Statamic control panel, you will see a new section called "Webhook". This is where you can add the webhook URL, each time an event happens in Statamic, the webhook will be triggered using a `POST` request.
