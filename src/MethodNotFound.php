<?php

namespace alcamo\exception;

/**
 * @brief Exception thrown when attempting to call a non-existent method.
 *
 * Typically used in the magic method __call().
 *
 * @date Last reviewed 2025-10-07
 */
class MethodNotFound extends \BadMethodCallException implements
    ExceptionInterface
{
    use ExceptionTrait {
        ExceptionTrait::setMessageContext as parentSetMessageContext;
    }

    /** @copybrief alcamo::exception::AbsolutePathNeeded::NORMALIZED_MESSAGE */
    public const NORMALIZED_MESSAGE =
        'Method {method} not found in object {object}';

    /**
     * @copydoc alcamo::exception::ExceptionInterface::setMessageContext()
     *
     * Add object from backtrace if not given in $context.
     */
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
