# Better reflection

Reflection that accounts for features that are in static analysers, but aren't in the language yet.

### Main points:
  - don't reinvent the wheel: use existing PHPStan (and other analysers possibly) and native reflection 
	infrastructure as a source of information
  - don't attempt to cover "PHP magic". No `@property` support. No `@method` support unless used for
    method overloading. No support for stupid built-in objects like `stdClass` or `SimpleXML`. No `@mixin` support.
  - speed & caching is key. This must be fast enough to consistently use in production.

## Design decisions

### Cache storage
We can't and don't really want to put reflection metadata into files containing the classes in a form 
of attributes as this would bring a lot of visual noise for developers and dangerous code modification
on CI container build or on production itself. This isn't ideal, even though is fast.

Instead, we're storing reflection metadata per-class in a separate "caching" folder and base it around 
file modification date. If anything changes in a file, the previous cache gets overwritten.

## Commands
Install dependencies:
`docker run -it --rm -v $PWD:/app -w /app composer install`

Run tests:
`docker run -it --rm -v $PWD:/app -w /app php:7.4-cli vendor/bin/pest`

Run php-cs-fixer on self:
`docker run -it --rm -v $PWD:/app -w /app composer cs-fix`

## Psalm support
Psalm doesn't have a nice, flexible infrastructure behind it like PHPStan does, so we can't really
use it for our needs. PHPStan provides `ReflectionProvider` interface and it's complete implementation
while there's not really a proper alternative in Psalm that doesn't feel like it will break any minute.
