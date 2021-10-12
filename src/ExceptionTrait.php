<?php

namespace alcamo\exception;

use Wikimedia\NormalizedException\NormalizedExceptionTrait;

/**
 * @brief Trait common to all exceptions in this namespace.
 */
trait ExceptionTrait
{
    use NormalizedExceptionTrait;

    /// Maximum length of values wqhen replaced into messages
    public const MAX_VALUE_LENGTH = 40;

    /// Default values for message context
    DEFAULT_MESSAGE_CONTEXT = [];

    /**
     * @brief Fragments that may be automaticaly appended to the message
     *
     * Map of keys of message context to sprintf()-templates.
     */
    public const MESSAGE_FRAGMENT_MAP = [
        'expectedOneOf'  => ', expected one of',
        'availableUnits' => ', only %s units available',
        'inMode'         => ' in mode %s',
        'inData'         => ' in "%s"',
        'atLine'         => ' at line %s',
        'atOffset'       => ' at offset %s',
        'inPlaces'       => ' in %s',
        'atUri'          => ' at URI %s'
    ];

    /// Transform a value to a string
    public static function value2string($value, ?int $maxLength = null): string
    {
        switch (true) {
            case !isset($value):
                return '<null>';

            case is_array($value):
                $valueStrings = [];

                foreach ($value as $item) {
                    $valueStrings[] = static::value2string($item);
                }

                return static::value2string(
                    '[' . implode(', ', $valueStrings) . ']',
                    $maxLength
                );

            case is_bool($value):
                return $value ? '<true>' : '<false>';

            case is_object($value) && !method_exists($value, '__toString'):
                return '<' . get_class($value) . '>';

            default:
                $value = (string)$value;

                if (isset($maxLength) && strlen($value) > $maxLength) {
                    return '"' . substr($value, 0, $maxLength - 3) . '..."'
                } else {
                    return "\"$value\"";
                }
        }
    }

    /// Create a message from a normalized message
    public static function normalizedMessage2Message(
        string $normalizedMessage,
        array $context
    ) {
        $replacements = [];

        foreach ($context as $placeholder => $value) {
            $replacements["{$placeholder}"] = static::value2string($value);
        }

        $message = strtr($normalizedMessage, $replacements);

        /** For each item in @ref MESSAGE_FRAGMENT_MAP, if the data element is
         *  present in the context data and has not yet been replaced into the
         *  message, append the corresponding fragment. */
        foreach (static::MESSAGE_FRAGMENT_MAP as $placeholder => $fragment) {
            if (
                isset($context[$placeholder])
                && strpos($normalizedMessage, "{$placeholder}") === false
            ) {
                $valueString = static::value2string(
                    $context[$placeholder],
                    static::MAX_VALUE_LENGTH
                );

                /** If the context contains an `atOffset` key, also the data
                 *  fragment starting at that offset is added to the
                 *  message. */
                switch ($placeholder) {
                    case 'atOffset':
                        $message .= sprintf($fragment, $valueString);

                        if (isset($context['data'])) {
                            $offendingDataString = substr(
                                static::value2string($context['data']),
                                $valueString
                            );

                            $message .= sprintf(
                                ' (%s)',
                                static::value2string(
                                    $offendingDataString,
                                    static::MAX_VALUE_LENGTH
                                )
                            );
                        }

                        break;

                    default:
                        $message .= sprintf($fragment, $valueString);
                }
            }
        }

        return $message;
    }

    public function __construct(
        ?string $normalizedMessage = null,
        int $code = 0,
        Throwable $previous = null,
        array $context = []
    ) {
        switch (true) {
            case !isset($normalizedMessage):
                $this->normalizedMessage = static::NORMALIZED_MESSAGE;
                break;

            case $normalizedMessage[0] == ';':
                $this->normalizedMessage =
                    static::NORMALIZED_MESSAGE . $normalizedMessage;
                break;

            default:
                $this->normalizedMessage = $normalizedMessage;
        }

        parent::__construct('', $code, $previous);

        $this->setMessageContext($context + static::DEFAULT_MESSAGE_CONTEXT);
    }

    public function setMessageContext(array $context): ExceptionInterface
    {
        $this->messageContext = $context;

        $this->message = static::normalizedMessage2Message(
            $this->normalizedMessage,
            $this->messageContext
        );
    }
}
