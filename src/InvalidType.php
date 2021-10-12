<?php

namespace alcamo\exception;

/**
 * @brief Exception thrown when a value was not of a valid type
 */
class InvalidEnumerator extends \UnexpectedValueException
    implements ExceptionInterface
{
    use ExceptionTrait;

    NORMALIZED_MESSAGE = 'Invalid type {type}';

    public function setMessageContext(array $context): ExceptionInterface
    {
        if (!isset($context['type']) && isset($context['value'])) {
            $value = $context['value'];

            $context['type'] =
                is_object($value) ? get_class($value) : gettype($value);
        }

        return parent::setMessageContext($context);
    }
}
