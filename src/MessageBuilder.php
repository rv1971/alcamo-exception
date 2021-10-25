<?php

namespace alcamo\exception;

/// Exception message builder
class MessageBuilder
{
    /// Maximum length of values when replaced into messages
    public const MAX_VALUE_LENGTH = 40;

    public const NO_QUOTE   = 1; ///< Do not quote a string literal
    public const NO_SHORTEN = 2; ///< Do not shorten a string literal
    public const NO_CLASS   = 4; ///< Do not prepend object class to string

    /// Flags for value2string()
    public const PLACEHOLDER_FLAGS = [
        'atUri'        => self::NO_SHORTEN | self::NO_CLASS,
        'extraMessage' => self::NO_QUOTE | self::NO_SHORTEN | self::NO_CLASS,
        'inMethod'     => self::NO_QUOTE | self::NO_CLASS,
        'objectType'   => self::NO_QUOTE | self::NO_SHORTEN | self::NO_CLASS
    ];

    /**
     * @brief Fragments that may be appended automatically to the message
     *
     * Map of keys of message context to sprintf()-templates. Used in the
     * order given here.
     */
    public const MESSAGE_FRAGMENT_MAP = [
        'expectedOneOf'  => ', expected one of %s',
        'availableUnits' => ', only %s units available',
        'inMode'         => ' in mode %s',
        'inMethod'       => ' in method %s()',
        'inData'         => ' in %s',
        'atLine'         => ' at line %s',
        'atOffset'       => ' at offset %s',
        'inPlaces'       => ' in %s',
        'atUri'          => ' at URI %s',
        'extraMessage'   => '; %s'
    ];

    /// Transform a value to a string for display in messages
    public function value2string(
        $value,
        ?int $flags = null,
        ?int $maxLength = null
    ): string {
        switch (true) {
            case !isset($value):
                return '<null>';

            case is_array($value):
                $valueStrings = [];

                foreach ($value as $item) {
                    $valueStrings[] = static::value2string($item, $flags);
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

                /* In the following cases it is known that $value can be
                 * converted to string. */

            case $flags & self::NO_QUOTE
                && $flags & self::NO_SHORTEN
                && $flags & self::NO_CLASS:
                return addcslashes($value, "\0..\37");

            case $flags & self::NO_SHORTEN && $flags & self::NO_CLASS:
                return '"' . addcslashes($value, "\0..\37") . '"';

                // prepend object type, if any, quote and shorten
            default:
                $typeLiteral = is_object($value) && !($flags & self::NO_CLASS)
                    ? '<' . get_class($value) . '>'
                    : '';

                $value = addcslashes($value, "\0..\37");

                if (
                    !($flags & self::NO_SHORTEN)
                    && isset($maxLength) && strlen($value) > $maxLength
                ) {
                    $value = substr($value, 0, $maxLength - 3) . '...';
                }

                return $typeLiteral
                    . ($flags & self::NO_QUOTE ? $value : "\"$value\"");
        }
    }

    /// Create a message from a normalized message
    public function normalizedMessage2Message(
        string $normalizedMessage,
        array $context
    ) {
        $replacements = [];

        $maxLength = static::MAX_VALUE_LENGTH;

        /// Replace context values into placeholders
        foreach ($context as $placeholder => $value) {
            $valueString = static::value2string(
                $context[$placeholder],
                static::PLACEHOLDER_FLAGS[$placeholder] ?? null,
                $maxLength
            );

            $replacements['{' . $placeholder . '}'] = $valueString;
        }

        $message = strtr($normalizedMessage, $replacements);

        /** For each item in @ref MESSAGE_FRAGMENT_MAP, if the data element is
         *  present in the context data *and has not yet been replaced* into
         *  the message, append the corresponding fragment. */
        foreach (static::MESSAGE_FRAGMENT_MAP as $placeholder => $fragment) {
            if (
                isset($context[$placeholder])
                && strpos($normalizedMessage, "{$placeholder}") === false
            ) {
                $valueString = static::value2string(
                    $context[$placeholder],
                    static::PLACEHOLDER_FLAGS[$placeholder] ?? null,
                    $maxLength
                );

                switch ($placeholder) {
                    /** If the context contains an `atOffset` key, also the
                     *  data fragment starting at that offset is added to the
                     *  message. */
                    case 'atOffset':
                        $message .= sprintf($fragment, $valueString);

                        if (isset($context['inData'])) {
                            $dataString = static::value2string(
                                $context['inData'],
                                static::PLACEHOLDER_FLAGS['inData'] ?? null
                            );

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

                    default:
                        $message .= sprintf($fragment, $valueString);
                }
            }
        }

        return $message;
    }
}
