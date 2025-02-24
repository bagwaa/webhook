# Statamic Webhook

> Statamic Webhook is a Statamic addon that sends statamic events to a webhook URL of your choice.

## Features

![Settings Page](screenshot.png)

This addon allows you to::

- Specify a webhook URL to send events to
- Enable / Disable certain events
- Provide a header for the webhook which is typically used for authentication

## How to Install

Require the package using composer.

``` bash
composer require bagwaa/webhook
```

## How to Use

Within the control panel you can find the settings for the addon under the `Webhook` section. Here you can specify the URL you want to send the events to, along with a header, and also enable / disable certain events to cut out some of the noise
