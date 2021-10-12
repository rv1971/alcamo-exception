<?php

namespace alcamo\exception;

/// Exception thrown by an attempt to open an already opened object
class Opened extends AbstractObjectStateException
{
    NORMALIZED_MESSAGE = 'Attempt to open already opened object {object}';
}
