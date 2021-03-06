# Thumbnails Documentation

## Installation

#### Install via composer:

```
composer require codebyflame/thumbnails
```

Then publish the publishables from the service provider:

```
php artisan vendor:publish --provider="CodeByFlame\Thumbnails\ServiceProvider"
```

#### Install via CP

You can also search for Thumbnails in `Tools > Addons` section of the Statamic control panel.

## Tags

In order to make this plugin work you need to add the `{{ thumbnails }}` tag inside the `<head>` element of every page.

## Fields it listens to
- It will take the `title` field for the text generated in the social card's image, as well as the social card's title content.
- It will take the `description` field, if present, for the social card's description content.

## Permissions
You can give access to the thumbnails settings to all, some or no users.
