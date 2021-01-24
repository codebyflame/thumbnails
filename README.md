# Thumbnails plugin for Statamic

Thumbnails plugin will generate social media thumbnail images on the fly based on 
the title of a collection item available via the link shared (and description, if present). 
This will allow you to be seen on social media even if your content doesn't have imagery and thus 
increases engagement. 

## Installation
Simply add `{{ thumbnails }}` to the `<head>` of every page. 

## Fields it listens to
- It will take the `title` field for the text generated in the social card's image, as well as the social card's title content.
- It will take the `description` field, if present, for the social card's description content.

## Permissions
You can give access to the thumbnails settings to all, some or no users.
