<?php

namespace alcamo\exception;

/// Exception thrown when data ends prematurely
class Eof extends AbstractObjectStateException
{
    NORMALIZED_MESSAGE =
        'Failed to read {requestedUnits} unit(s) from {object}';
}
