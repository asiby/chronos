# Chronos

A PHP library to start timers for tracking the execution time of some operations in an application.

## Introduction

This library was inspired by the Google Chrome DevTools feature that let's you use `console.time()`, `console.timeLog()`, and `console.timeEnd()` to respectively create a timer, log the timer's value, and destroy the timer while printing out the final timer's value.
 
This is a PHP equivalent of that feature and it offers the following benefits:

- Dead easy to use
- Has no dependencies
- Extremely passive ... it will not throw any error if you don't use it properly.

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

Note that for the sake of simplicity, `Chronos` provides static methods only.

Each timer has to have a unique identifier (the label) that will be used when generating the output for that timer.

### Creating a timer

```
Chronos::time([$label = 'default'], [$verbose = false]);
```

#### Parameters:

- `$label`: Optional String (default: 'default'). This is the unique identifier for the timer being created.
- `$verbose`: Optional String (default: false). This parameter will make the timer generate some extra information.

#### Output:

```
Started a new timer with the label 'default'
```

This function will only generate an output if the verbose mode is enabled. The name of the label will be included in the generated output.

The `time()` function can be called as many time as needed with different labels. Nothing will happen if you try to create a timer that already exists.

#### Examples:

Creating a default timer. 

```php
use ASiby\Chronos;
// ...

Chronos::time();
```

Creating a timer called `Time taken by the database call`. 

```php
use ASiby\Chronos;
// ...

Chronos::time("Time taken by the database call");
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
Chronos::logTime([$label = 'default'], [$description = null], [$showDelta = true]);
```

#### Parameters:

- `$label`: Optional String (default: 'default'). This is the unique identifier for the timer being created.
- `$description`: Optional String (default: null). Extra text that allows identifying the context related to a particular time log.
- `$showDelta`: Optional String (default: true). Include the relative time since the last time `logTime()` was called. The first call to `logTime()` will no show a delta.

You can't call `logTime()` before calling `time()` for a given timer.

#### Alias

```
Chronos::timeLog([$label = 'default'], [$description = null], [$showDelta = true]);
```

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
Chronos::logTime(null, "First logTime()");
usleep(1500000);
Chronos::logTime(null, "Second logTime()", false);
usleep(500000);
Chronos::logTime(null, "Third logTime()");
usleep(1500000);
Chronos::logTime();
usleep(1500000);
Chronos::logTime();
usleep(500000);
Chronos::logTime();
```

```
Chronos::time(null, true);
usleep(1500000);
Chronos::logTime(null, "First logTime()");
usleep(1500000);
Chronos::logTime(null, "Second logTime()");
usleep(500000);
Chronos::logTime(null, "Third logTime()");
usleep(1500000);
Chronos::logTime();
usleep(1500000);
Chronos::logTime();
usleep(500000);
Chronos::logTime();
```

### Destroying a timer

```
Chronos::endTime([$label = 'default'], [$description = null]);
```

This function will destroy the timer and log its value, label and optional description provided at the time of the call. 

#### Parameters:

- `$label`: Optional String (default: 'default'). This is the unique identifier for the timer being created.
- `$description`: Optional String (default: null). Extra text that allows identifying the context related to a particular time log.

The `endTime()` function is the last action that can be performed with a timer. Any subsequent call to `logTime()` with fail.

#### Alias

```
Chronos::timeEnd([$label = 'default'], [$description = null], [$showDelta = true]);
```

#### Output:

The second line is logged when the verbose mode was used when creating the timer.

```
default: 10.0224950314s (final)
Terminated a new timer with the label 'default'
```

## Credits

This implementation is inspired by a Google Chrome DevTools feature.

## Contributing

Improvements are welcome! Feel free to submit pull requests.

## Licence

MIT

Copyright © 2020 - [Abdoulaye Siby](https://abdoulaye.com)
