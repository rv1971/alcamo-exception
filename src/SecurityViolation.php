<?php

namespace alcamo\exception;

/**
 * @brief Exception thrown when something violates seceurity rules
 *
 * @date Last reviewed 2026-03-10
 */
class SecurityViolation extends \RuntimeException implements ExceptionInterface
{
    use ExceptionTrait;

    /** @copybrief alcamo::exception::AbsolutePathNeeded::NORMALIZED_MESSAGE */
    public const NORMALIZED_MESSAGE = 'Security Violation';
}
