<?php

namespace alcamo\exception;

/**
 * @brief Exception related the state of an object
 *
 * @date Last reviewed 2025-10-07
 */
abstract class AbstractObjectStateException extends ProgramFlowException
{
    public const DEFAULT_MESSAGE_CONTEXT = [ 'objectType' => 'object' ];

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

        return parent::setMessageContext($context, $messageFactory);
    }
}
