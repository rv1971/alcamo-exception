<?php

namespace alcamo\exception;

/// Exception thrown by an attempt to use an already closed object
class Closed extends AbstractObjectStateException
{
    NORMALIZED_MESSAGE = 'Attempt to use closed object {object}';
}
