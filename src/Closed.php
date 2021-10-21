<?php

namespace alcamo\exception;

/// Exception thrown by an attempt to use an already closed object
class Closed extends AbstractObjectStateException
{
    public const NORMALIZED_MESSAGE =
        'Attempt to use closed {objectType} {object}';
}
