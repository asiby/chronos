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

## Importing the library

Use the following statement at the top of any code where you intend to use `Chronos`.

```php
use ASiby\Chronos;
```

## API Documentation

Note that for the sake of simplicity, `Chronos` provides static method only.

Each timer has to have unique identified (the label) that will be used when generating the output for that timer.

### Creating a timer

```
time([$label = 'default'], [$verbose = false]);
```

#### Parameters:

- `$label`: Optional String (default: 'default'). This is the unique identifier for the timer being created.
- `$verbose`: Optional String (default: false). This parameter will make the timer generate some extra information.

#### Output:

This function will only generate an output if the verbose mode is enabled. The name of the label will be included in the generated output.

The `time()` function can be called as many time as needed with different labels. Trying to create a timer that already exist will cause an error to be thrown.

```
Started a new timer with the label 'default'
```

#### Examples:

Creating a default timer. 

```php
use ASiby\Chronos;
// ...

Chronos::time();
```

Creating a timer called `Time taken buy the database call`. 

```php
use ASiby\Chronos;
// ...

Chronos::time("Time taken buy the database call");
```

Creating a timer called `API Request Time` with the verbose mode enabled. 

```php
use ASiby\Chronos;
// ...

Chronos::time("API Request Time", true);
```

Creating a timer with the default label but with the verbose mode enabled. 

```php
use ASiby\Chronos;
// ...

Chronos::time(null, true);
```

### Printing a timing log

```
timelog([$label = 'default'], [$description = null], [$showDelta = true]);
```

#### Parameters:

- `$label`: Optional String (default: 'default'). This is the unique identifier for the timer being created.
- `$description`: Optional String (default: null). Extra text that allows identifying the context related to a particular time log.
- `$showDelta`: Optional String (default: true). Include the relative time since the last time `timeLog()` was called. The first call to `timeLog()` will no show a delta.

The `timeLog()` function has to be called after calling `time()` with the same label or the default label.

#### Output:

First call ...

```
default: 1.5044138432s
```

Subsequent calls ... Note that the delta is option and is controlled by the `showDelta` flag.

```
default: 3.0088098049s - Time log delta: 1.5043959618s
```

Time log that has a description attached

```
default: 3.0088098049s - Time log delta: 1.5043959618s - This is the second time log
```

Using friendly label.

```
The execution time is: 3.0088098049s - Time log delta: 1.5043959618s - This is the second time log
```

#### Examples:

Printing the time log for the default timer. 

```php
use ASiby\Chronos;

Chronos::time(null, true);
usleep(1500000);
Chronos::timeLog(null, "First timeLog()");
usleep(1500000);
Chronos::timeLog(null, "Second timeLog()", false);
usleep(500000);
Chronos::timeLog(null, "Third timeLog()");
usleep(1500000);
Chronos::timeLog();
usleep(1500000);
Chronos::timeLog();
usleep(500000);
Chronos::timeLog();
```

```
Chronos::time(null, true);
usleep(1500000);
Chronos::timeLog(null, "First timeLog()");
usleep(1500000);
Chronos::timeLog(null, "Second timeLog()");
usleep(500000);
Chronos::timeLog(null, "Third timeLog()");
usleep(1500000);
Chronos::timeLog();
usleep(1500000);
Chronos::timeLog();
usleep(500000);
Chronos::timeLog();
```

Creating a timer called `Time taken buy the database call`. 

```php
use ASiby\Chronos;
// ...

Chronos::time("Time taken buy the database call");
```

## Credits

This implementation is inspired by a Google Chrome DevTools feature.

## Contributing

Improvements are welcome! Feel free to submit pull requests.

## Licence

MIT

Copyright © 2020 - [Abdoulaye Siby](https://abdoulaye.com)
