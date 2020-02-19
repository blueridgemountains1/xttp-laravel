# [xttp](https://github.com/jr-smith/xttp) for Laravel

### A guzzle wrapper with typehints and syntactic sugar.

Regular use is simple:

```php
<?php
use JohnathanSmith\XttpLaravel\Xttp;

/** @var \JohnathanSmith\Xttp\XttpResponseWrapper $xttpResponse */

$xttpResponse = Xttp::post('https://johnathansmith.com', ['form_params' => ['foo' => 'bar'], 'headers' => ['Content-Type' => 'application/x-www-form-urlencoded']]);

// You may also do get, put, patch, delete.
```

However, this package provides a **lot** of flexibility and ability for easy
mocking. It also allows for easy use of things like middleware and JSON
en/decoding.

Please [view the original package](https://github.com/jr-smith/xttp) for more
details, how-to's, and documentation.

Xttp was inspired by Adam Wathan's [zttp](https://github.com/kitetail/zttp). A
special thanks to the maintainers of Guzzle.
