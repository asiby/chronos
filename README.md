# Chronos

A PHP library to start a timer you can use to track how long an operation takes.

## Introduction

This library was inspired by the Google Chrome DevTools feature that let's you use `console.time()`, `console.timeLog()`, and `console.timeEnd()` to output respectively create a time, log the timer's value, and destroy the timer while printing out the final timer's value.
 
This is a PHP equivalent of that feature and it offers the following benefits

- Dead easy to use
- Has no dependencies

## Installation

```shell
composer require asiby/chronos
```

## Documentation

To do ...

Use the following statement at the top of any code where you intend to use `Chronos`:

```php
use ASiby\Chronos;
```

Creating a timer

```php
Chronos::time();
```

Output:
```
...
```

## Credits

This implementation is inspired by a Google Chrome DevTools feature.

## Contributing

Improvements are welcome! Feel free to submit pull requests.

## Licence

MIT

Copyright © 2020 [Abdoulaye Siby](https://abdoulaye.com)
