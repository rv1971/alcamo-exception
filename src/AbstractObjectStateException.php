<?php

namespace alcamo\exception;

/// Exception related the state of an object
abstract class AbstractObjectStateException extends ProgramFlowException
{
    public const DEFAULT_MESSAGE_CONTEXT = [ 'objectType' => 'object' ];

    /// Get object from backtrace if not given
    public function setMessageContext(array $context): ExceptionInterface
    {
        if (!isset($context['object'])) {
            $context['object'] = \debug_backtrace()[2]['object'];
        }

        return parent::setMessageContext($context);
    }
}
