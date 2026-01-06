# Get Main Site Name plugin

This will output the name of the main site in a WordPress Multisite setup. If not in a multisite environment, it will return the name of the current site.

## Usage

Use the helper function `get_main_site_name_helper()` anywhere in your theme or plugin.

## Example

```php
<?php

echo get_main_site_name_helper();
```
