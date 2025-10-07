<?php

namespace alcamo\exception;

/**
 * @brief Exception thrown when a value was not of a valid type
 *
 * @date Last reviewed 2025-10-07
 */
class InvalidType extends \UnexpectedValueException implements
    ExceptionInterface
{
    use ExceptionTrait {
        ExceptionTrait::setMessageContext as parentSetMessageContext;
    }

    public const NORMALIZED_MESSAGE = 'Invalid type {type}';

    /** If `type` is not given in the context but `value` is, add the class or
     *  type of `value` as `type`. */
    public function setMessageContext(
        array $context,
        ?MessageFactoryInterface $messageFactory = null
    ): ExceptionInterface {
        if (!isset($context['type']) && isset($context['value'])) {
            $value = $context['value'];

            $context['type'] =
                is_object($value) ? get_class($value) : gettype($value);
        }

        return $this->parentSetMessageContext($context, $messageFactory);
    }
}
