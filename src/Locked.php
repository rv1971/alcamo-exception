<?php

namespace alcamo\exception;

/// Exception thrown by an attempt to modify a locked object
class Locked extends AbstractObjectStateException
{
    public const NORMALIZED_MESSAGE =
        'Attempt to modify locked object {object}';
}
