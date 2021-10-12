<?php

namespace alcamo\exception;

/**
 * @brief Exception thrown when a call to popen() or proc_open() failed
 */
class PopenFailed extends AbstractIoException
{
    NORMALIZED_MESSAGE = 'Failed to open process {command}';

    public function setMessageContext(array $context): ExceptionInterface
    {
        if (isset($context['command']) && is_array($context['command'])) {
            $context['command'] = implode(' ', $context['command']);
        }

        return parent::setMessageContext($context);
    }
}
