<?php

namespace alcamo\exception;

/**
 * @brief Exception thrown when attempting to call a non-existent method.
 *
 * Typically used in the magic method __call().
 */
class MethodNotFound extends \BadMethodCallException implements
    ExceptionInterface
{
    use ExceptionTrait {
        ExceptionTrait::setMessageContext as parentSetMessageContext;
    }

    public const NORMALIZED_MESSAGE =
        'Method {method} not found in object {object}';

    /// Get object from backtrace if not given
    public function setMessageContext(
        array $context,
        ?MessageFactoryInterface $messageFactory = null
    ): ExceptionInterface {
        if (!isset($context['object'])) {
            // if called from constructor, go back one step further
            $backtraceLevel =
                \debug_backtrace()[1]['object'] instanceof self ? 2 : 1;

            $context['object'] = \debug_backtrace()[$backtraceLevel]['object'];
        }

        return $this->parentSetMessageContext($context, $messageFactory);
    }
}
