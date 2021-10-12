<?php

namespace alcamo\exception;

/// Exception resulting from a bug in the program flow
class ProgramFlowException extends \LogicException
    implements ExceptionInterface
{
    use ExceptionTrait;
}
