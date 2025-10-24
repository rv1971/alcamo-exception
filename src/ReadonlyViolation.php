<?php

namespace alcamo\exception;

/**
 * @brief Exception thrown by an attempt to write to a readonly object
 *
 * @date Last reviewed 2025-10-07
 */
class ReadonlyViolation extends \LogicException implements ExceptionInterface
{
    use ExceptionTrait {
        ExceptionTrait::setMessageContext as parentSetMessageContext;
    }

    /** @copybrief alcamo::exception::AbsolutePathNeeded::NORMALIZED_MESSAGE */
    public const NORMALIZED_MESSAGE =
        'Attempt to modify readonly object {object}';

    /**
     * @copydoc alcamo::exception::ExceptionInterface::setMessageContext()
     *
     * Add object from backtrace if not given in $context
     */
    public function setMessageContext(
        array $context,
        ?MessageFactoryInterface $messageFactory = null
    ): ExceptionInterface {
        if (isset(\debug_backtrace()[1]['object'])) {
            // if called from constructor, go back one step further
            $backtraceLevel =
                \debug_backtrace()[1]['object'] instanceof self ? 2 : 1;

            if (
                !isset($context['object'])
                && isset(\debug_backtrace()[$backtraceLevel]['object'])
            ) {
                $context['object'] =
                    \debug_backtrace()[$backtraceLevel]['object'];
            }

            if (!isset($context['inMethod'])) {
                $context['inMethod'] =
                    \debug_backtrace()[$backtraceLevel]['function'];
            }
        }

        return $this->parentSetMessageContext($context, $messageFactory);
    }
}
