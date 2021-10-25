<?php

namespace alcamo\exception;

/**
 * @brief Exception thrown when a call to popen() or proc_open() failed
 */
class PopenFailed extends AbstractIoException
{
    public const NORMALIZED_MESSAGE = 'Failed to open process {command}';

    /** If `command` is given as an array, transform it to string. */
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
