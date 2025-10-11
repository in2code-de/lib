# co-stack.com lib

(Only active branch badges are listed)

PHP 8.4
[![pipeline status](https://gitlab.com/co-stack.com/co-stack.com/php-packages/lib/badges/php84/pipeline.svg)](https://gitlab.com/co-stack.com/co-stack.com/php-packages/lib/-/pipelines)
[![coverage report](https://gitlab.com/co-stack.com/co-stack.com/php-packages/lib/badges/php84/coverage.svg)](https://gitlab.com/co-stack.com/co-stack.com/php-packages/lib/-/graphs/php82/charts) \
PHP 8.3
[![pipeline status](https://gitlab.com/co-stack.com/co-stack.com/php-packages/lib/badges/php83/pipeline.svg)](https://gitlab.com/co-stack.com/co-stack.com/php-packages/lib/-/pipelines)
[![coverage report](https://gitlab.com/co-stack.com/co-stack.com/php-packages/lib/badges/php83/coverage.svg)](https://gitlab.com/co-stack.com/co-stack.com/php-packages/lib/-/graphs/php82/charts) \
PHP 8.2
[![pipeline status](https://gitlab.com/co-stack.com/co-stack.com/php-packages/lib/badges/php82/pipeline.svg)](https://gitlab.com/co-stack.com/co-stack.com/php-packages/lib/-/pipelines)
[![coverage report](https://gitlab.com/co-stack.com/co-stack.com/php-packages/lib/badges/php82/coverage.svg)](https://gitlab.com/co-stack.com/co-stack.com/php-packages/lib/-/graphs/php82/charts) \
PHP 8.1
[![pipeline status](https://gitlab.com/co-stack.com/co-stack.com/php-packages/lib/badges/php81/pipeline.svg)](https://gitlab.com/co-stack.com/co-stack.com/php-packages/lib/-/pipelines)
[![coverage report](https://gitlab.com/co-stack.com/co-stack.com/php-packages/lib/badges/php81/coverage.svg)](https://gitlab.com/co-stack.com/co-stack.com/php-packages/lib/-/graphs/php81/charts)

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

## Classes list

_This list does not include classes which are aliases/wrappers for functions._

* `\CoStack\Lib\Contract\Invokable`: An interface to force classes to implement `__invoke` like `Stringable`.
* `\CoStack\Lib\Generic\Uri`: (Immutable) Basic URI implementation with methods to create variations.
* `\CoStack\Lib\Pattern\MagicMethodsForImmutables`: A trait which implements `__call` to make all properties `get`-, `with`- and `without`-able.
* `\CoStack\Lib\Pattern\Singleton`: The classic singleton pattern. Note that singletons must not have constructor arguments and you are not allowed to override `__construct`.
* `\CoStack\Lib\Utility\StringPool`: Reduces memory usage by interning strings. Refer to `pool` DocBlock.

## Function list

* `array_filter_recursive`: Like `array_filter`, but recursively.
* `array_value`: Get an array value by an index path.
* `array_property`: `array_column` for objects
* `array_unique_keys`: Get an array of all distinct keys fo all arrays.
* `concat_paths`: Concatenate filesystem paths without duplicate directory separators.
* `mkdir_deep`: `mkdir` with the `recursive` flag, but without `mode`.
* `factory`: Creates a new object by mapping an associative array to constructor arguments and public properties.
* `filter`: Factory for simple filter closures for use with `array_filter`.
* `cgi_parse_str`: A pure and actually CGI compliant parse_str alternative.
* `pool`: Alias for `\CoStack\Lib\Utility\StringPool::get`.
* `enumerate`: Implode strings for natural (human) language.

## Compatibility

There is one branch for each supported PHP version. Each branch has its own major version number.
Only PHP versions, which are officially maintained are supported.
Lower supported versions receive backports of all features, which are possible in that PHP Version.
(e.g. type annotations will be backported, but Attributes will not be available below PHP 8.0)

| Version | PHP Version | Branch Name | Maintained until | Currently Supported |
|---------|-------------|-------------|------------------|---------------------|
| 1.x     | 7.2         | php72       | 31 Jul 2021      | ❌                   |
| 2.x     | 7.3         | php73       | 6 Dec 2021       | ❌                   |
| 3.x     | 7.4         | php74       | 28 Nov 2022      | ❌                   |
| 4.x     | 8.0         | php80       | 26 Nov 2023      | ❌                   |
| 5.x     | 8.1         | php81       | 31 Dec 2025      | ❌                   |
| 6.x     | 8.2         | php82       | 31 Dec 2026      | ✅                   |
| 7.x     | 8.3         | php83       | 31 Dec 2027      | ✅                   |
| 8.x     | 8.4         | php84       | 31 Dec 2028      | ✅                   |
