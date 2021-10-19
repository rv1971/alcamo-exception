<?php

namespace alcamo\exception;

/**
 * @brief Exception thrown when a value was not in the expected range
 */
class OutOfRange extends \UnexpectedValueException implements
    ExceptionInterface
{
    use ExceptionTrait;

    public const NORMALIZED_MESSAGE =
        'Value {value} out of range [{lowerBound}, {upperBound}]';

    public const DEFAULT_MESSAGE_CONTEXT = [
        'lowerBound' => '-∞',
        'upperBound' => '∞'
    ];

    /**
     * @brief Throw if $value outside [$lowerBound, $upperBound]
     *
     * @param $lowerBound lower bound, ignored if `null`
     *
     * @param $upperBound upper bound, ignored if `null`
     */
    public static function throwIfOutside(
        $value,
        $lowerBound,
        $upperBound,
        ?array $context
    ): void {
        if (
            isset($lowerBound) && $value < $lowerBound
            || isset($upperBound) && $value > $upperBound
        ) {
            throw (new self())->setMessageContext(
                [
                    'value' => $value,
                    'lowerBound' => $lowerBound,
                    'upperBound' => $upperBound
                ]
                + (array)$context
            );
        }
    }
}
