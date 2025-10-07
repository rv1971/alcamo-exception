<?php

namespace alcamo\exception;

/**
 * @brief Exception resulting from a bug in the program flow
 *
 * Has no default normalized message.
 *
 * @date Last reviewed 2025-10-07
 */
class ProgramFlowException extends \LogicException implements
    ExceptionInterface
{
    use ExceptionTrait;
}
