<?php

namespace alcamo\exception;

/// Exception thrown by an attempt to access an uninitialized object
class Uninitialized extends AbstractObjectStateException
{
    NORMALIZED_MESSAGE = 'Attempt to access uninitialized object {object}';
}
