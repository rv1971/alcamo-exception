<?php

namespace alcamo\exception;

/**
 * @brief Exception thrown when a child process failed
 *
 * @date Last reviewed 2025-10-07
 */
class ProcessFailed extends AbstractIoException
{
    /** @copybrief alcamo::exception::AbsolutePathNeeded::NORMALIZED_MESSAGE */
    public const NORMALIZED_MESSAGE = 'Process {command} failed';

    /**
     * @copydoc alcamo::exception::ExceptionInterface::setMessageContext()
     *
     * If `command` is given as an array, transform it to string.
     */
    public function setMessageContext(
        array $context,
        ?MessageFactoryInterface $messageFactory = null
    ): ExceptionInterface {
        if (isset($context['command']) && is_array($context['command'])) {
            $context['command'] = implode(' ', $context['command']);
        }

        return parent::setMessageContext($context, $messageFactory);
    }
}
