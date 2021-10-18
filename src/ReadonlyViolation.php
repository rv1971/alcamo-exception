<?php

namespace alcamo\exception;

/**
 * @brief Exception thrown by an attempt to write to a readonly object
 */
class ReadonlyViolation extends \LogicException implements ExceptionInterface
{
    use ExceptionTrait {
        ExceptionTrait::setMessageContext as parentSetMessageContext;
    }

    public const NORMALIZED_MESSAGE =
        'Attempt to modify readonly object {object}';

    /// Get object and method from backtrace if not given
    public function setMessageContext(array $context): ExceptionInterface
    {
        if (!isset($context['object'])) {
            $context['object'] = \debug_backtrace()[2]['object'];
        }

        if (!isset($context['inMethod'])) {
            $context['inMethod'] = \debug_backtrace()[2]['function'];
        }

        return $this->parentSetMessageContext($context);
    }
}
