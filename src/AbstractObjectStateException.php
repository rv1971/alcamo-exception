<?php

namespace alcamo\exception;

/// Exception related the state of an object
abstract class AbstractObjectStateException extends ProgramFlowException
{
    public const DEFAULT_MESSAGE_CONTEXT = [ 'objectType' => 'object' ];
}
