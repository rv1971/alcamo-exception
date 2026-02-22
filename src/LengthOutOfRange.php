<?php

namespace alcamo\exception;

/**
 * @brief Exception thrown when a value length was not in the expected range
 *
 * @date Last reviewed 2026-02-20
 */
class LengthOutOfRange extends \UnexpectedValueException implements
    ExceptionInterface
{
    use ExceptionTrait;

    /** @copybrief alcamo::exception::AbsolutePathNeeded::NORMALIZED_MESSAGE */
    public const NORMALIZED_MESSAGE =
        'Length {length} of {value} out of range [{lowerBound}, {upperBound}]';

    /** @copydoc  alcamo::exception::AbstractObjectStateException::DEFAULT_MESSAGE_CONTEXT */
    public const DEFAULT_MESSAGE_CONTEXT = [
        'lowerBound' => 0,
        'upperBound' => '∞'
    ];

    /**
     * @brief Throw if length of $value outside [$lowerBound, $upperBound]
     *
     * @param $lowerBound lower bound, ignored if `null`
     *
     * @param $upperBound upper bound, ignored if `null`
     *
     * @param $length Length of value. If not provided, strlen($value) is
     * used.
     *
     * Convenience method to throw an exception when needed.
     */
    public static function throwIfOutside(
        $value,
        $lowerBound,
        $upperBound,
        $length = null,
        ?array $context = null
    ): void {
        if (!isset($length)) {
            $length = strlen($value);
        }

        if (
            isset($lowerBound) && $length < $lowerBound
            || isset($upperBound) && $length > $upperBound
        ) {
            throw (new self())->setMessageContext(
                [
                    'value' => $value,
                    'length' => $length,
                    'lowerBound' => $lowerBound,
                    'upperBound' => $upperBound
                ]
                + (array)$context
            );
        }
    }
}
