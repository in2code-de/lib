# co-stack.com lib

[![pipeline status](https://gitlab.com/co-stack.com/co-stack.com/php-packages/lib/badges/master/pipeline.svg)](https://gitlab.com/co-stack.com/co-stack.com/php-packages/lib/-/commits/master)
[![coverage report](https://gitlab.com/co-stack.com/co-stack.com/php-packages/lib/badges/master/coverage.svg)](https://gitlab.com/co-stack.com/co-stack.com/php-packages/lib/-/commits/master)

## About

co-stack.com lib provides generic everyday functions, which aim to help you to focus on your main task.
This package tries to achieve this by providing:
* intuitive function names
* high quality code
* constant performance optimization
* extensive documentation
* 100% test coverage
* dependency free code
* mostly pure functions
* namespaced functions
* Static Methods as OOP alternative

So you don't need to bother about performance or implementation details.

## Function list

* `array_filter_recursive`: Like `array_filter`, but recursively.
* `array_value`. Get an array value by an index path.
* `array_property`. `array_column` for objects
* `concat_paths`. Concatenate filesystem paths without duplicate directory separators.
* `mkdir_deep`. `mkdir` with the `recursive` flag, but without `mode`.
* `factory`. Creates a new object by mapping an associative array to constructor arguments.

## Compatibility

There is one branch for each supported PHP version. Each branch has its own major version number.
Only PHP versions, which are officially maintained are supported.
The master branch is on the same commit as the highest supported PHP Version Branch.
Lower supported versions receive backports of all features, which are possible in that PHP Version.
(e.g. type annotations will be backported, but Attributes will not be available below PHP 8.0)

| Version | PHP Version | Branch Name |
|-----|-----|-------|
| 1.x | 7.2 | php72 |
| 2.x | 7.3 | php73 |
| 3.x | 7.4 | php74 |
| 4.x | 8.0 | php80 |
