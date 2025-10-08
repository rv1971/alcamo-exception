# Usage examples

## Predefined exception classes

~~~
use alcamo\exception\InvalidEnumerator;

try {
    throw (new InvalidEnumerator())->setMessageContext(
        [
            'value' => 'fox',
            'expectedOneOf' => [ 'foo', 'bar', 'baz' ],
            'atLine' => 42
        ]
    );
} catch (\Exception $e) {
    echo $e->getMessage();
}
~~~

This will output

~~~
Invalid value "fox", expected one of ["foo", "bar", "baz"] at line 42.
~~~

The first part up to the comma is taken from
`InvalidEnumerator::NORMALIZED_MESSAGE`, the rest is created from the
context based on settings in `MessageFactory`.

A number of such predefined exception classes with default messages is
provided, as well as a number of context item definitions. Both may
easily be extended or modified.

Since the mechanism is based on the interface `ExceptionInterface` and
the trait `ExceptionTrait`, it can easily be integrated into any
existing exception class hierarchy.

## Error handler

~~~
use alcamo\exception\ErrorHandler;

public function foo()
{
    $handler = new ErrorHandler();
~~~

...
Any error occurring here will throw an `ErrorException`.
...

~~~
}
~~~

After leaving the scope, the `$handler` has been destroyed, hence
previous error handling is restored.

## Exception dumper

~~~
use alcamo\exception\Dumper;

try {
~~~
...
~~~
} catch (\Throwable $e) {
    echo (new Dumper())->dump($e);
}
~~~

Reports the details of the exception. Useful, for instance, in
command-line interfaces.


# Supplied generic interfaces, traits and classes

The following only explains what is needed to implement the mechanism
illustrated above. The provided predefined exception classes are
basically all trivial because they mainly consist of a class constant
with a normalized message.

## Interface `MessageFactoryInterface`

Simple interface requiring a method `createMessage()` which takes a
normalized message and a context array and returns a string.

## Class `MessageFactory`

Implementation of `MessageFactoryInterface` which extends the
functionality of Wikimedia's
`NormalizedExceptionTrait::getMessageFromNormalizedMessage()` in that
it not only replaces placeholders by context elements but generates
more message text from the context.

The generation of messages is configured by class constants which can
be extended or modified in derived classes. The present implementation
focuses on information where in the input data an exception was
thrown.

## Interface `ExceptionInterface`

Extends Wikimedia's
[INormalizedException](https://github.com/wikimedia/mediawiki-libs-NormalizedException/blob/v1.0.1/src/INormalizedException.php)
with two methods to set the message context and to add data to an
existing message context.

## Trait `ExceptionTrait`

Extends Wikimedia's
[NormalizedExceptionTrait](https://github.com/wikimedia/mediawiki-libs-NormalizedException/blob/v1.0.1/src/NormalizedExceptionTrait.php),
implementing `ExceptionInterface`. Uses `MessageFactory` (or any
injected object that implements `MessageFactoryInterface`) to generate
a message. The underlying normalized message can be taken from a class
constant.

## Class `ErrorHandler`

Implements the RAAI pattern to establish an error handler function as
long as the `ErrorHandler` object exists. The provided error handler
function throws an `ErrorException` and can be overridden in derived
classes.

## Class `Dumper`

Provides a method `dump()` to dump the details of a `Throwable` as
multiline text. The pieces of output are created by individual methods
so that it can easily be customized in derived classes.
