<?php

namespace alcamo\exception;

use Wikimedia\NormalizedException\NormalizedExceptionTrait;

/**
 * @brief Trait common to all exceptions in this namespace.
 */
trait ExceptionTrait
{
    use NormalizedExceptionTrait;

    /// Transform a value to a string for display in messages
    public static function value2string(
        $value,
        ?int $maxLength = null
    ): string {
        switch (true) {
            case !isset($value):
                return '<null>';

            case is_array($value):
                $valueStrings = [];

                foreach ($value as $item) {
                    $valueStrings[] = static::value2string($item);
                }

                $value = implode(', ', $valueStrings);

                if (isset($maxLength) && strlen($value) > $maxLength) {
                    return '[' . substr($value, 0, $maxLength - 3) . '...]';
                } else {
                    return "[$value]";
                }

            case is_bool($value):
                return $value ? '<true>' : '<false>';

            case is_float($value):
            case is_int($value):
                return $value;

            case is_object($value) && !method_exists($value, '__toString'):
                return '<' . get_class($value) . '>';

            default:
                $value = (string)$value;

                if (isset($maxLength) && strlen($value) > $maxLength) {
                    return '"' . substr($value, 0, $maxLength - 3) . '..."';
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

        $maxLength = defined('static::MAX_VALUE_LENGTH')
            ? static::MAX_VALUE_LENGTH
            : Constants::MAX_VALUE_LENGTH;

        /// Replace context values into placeholders
        foreach ($context as $placeholder => $value) {
            $valueString =
                static::value2string($context[$placeholder], $maxLength);

            switch ($placeholder) {
                case 'objectType':
                    if ($valueString[0] == '"' && $valueString[-1] == '"') {
                        $valueString = substr(
                            $valueString,
                            1,
                            strlen($valueString) - 2
                        );
                    }

                    break;
            }

            $replacements['{' . $placeholder . '}'] = $valueString;
        }

        $message = strtr($normalizedMessage, $replacements);

        /** For each item in @ref MESSAGE_FRAGMENT_MAP, if the data element is
         *  present in the context data *and has not yet been replaced* into
         *  the message, append the corresponding fragment. */
        foreach (
            (defined('static::MESSAGE_FRAGMENT_MAP')
             ? static::MESSAGE_FRAGMENT_MAP
             : Constants::MESSAGE_FRAGMENT_MAP) as $placeholder => $fragment
        ) {
            if (
                isset($context[$placeholder])
                && strpos($normalizedMessage, "{$placeholder}") === false
            ) {
                $valueString =
                    static::value2string($context[$placeholder], $maxLength);

                /** If the context contains an `atOffset` key, also the data
                 *  fragment starting at that offset is added to the
                 *  message. */
                switch ($placeholder) {
                    case 'atOffset':
                        $message .= sprintf($fragment, $valueString);

                        if (isset($context['inData'])) {
                            $dataString =
                                static::value2string($context['inData']);

                            if ($dataString[0] == '"') {
                                $offendingDataString = substr(
                                    $dataString,
                                    $valueString + 1,
                                    strlen($dataString) - $valueString - 2
                                );

                                if (strlen($offendingDataString) > $maxLength) {
                                    $offendingDataString =
                                        substr(
                                            $offendingDataString,
                                            0,
                                            $maxLength - 3
                                        ) . '...';
                                }

                                $message .= " (\"$offendingDataString\")";
                            }
                        }

                        break;

                    case 'extraMessage':
                        if ($valueString[0] == '"' && $valueString[-1] == '"') {
                            $valueString = substr(
                                $valueString,
                                1,
                                strlen($valueString) - 2
                            );
                        }

                        $message .= sprintf($fragment, $valueString);
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
        \Throwable $previous = null,
        array $context = []
    ) {
        $this->normalizedMessage =
            $normalizedMessage ?? static::NORMALIZED_MESSAGE;

        parent::__construct('', $code, $previous);

        $this->setMessageContext($context);
    }

    /// Set @ref messageContext and @ref $message, then return $this
    public function setMessageContext(array $context): ExceptionInterface
    {
        $this->messageContext = $context
            + (defined('static::DEFAULT_MESSAGE_CONTEXT')
               ? static::DEFAULT_MESSAGE_CONTEXT
               : Constants::DEFAULT_MESSAGE_CONTEXT);

        $this->message = static::normalizedMessage2Message(
            $this->normalizedMessage,
            $this->messageContext
        );

        return $this;
    }
}
