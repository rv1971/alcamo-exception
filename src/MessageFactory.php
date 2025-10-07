<?php

namespace alcamo\exception;

/**
 * @brief Exception message factory
 *
 * @date Last reviewed 2025-10-07
 */
class MessageFactory implements MessageFactoryInterface
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
        'filename'     => self::NO_SHORTEN,
        'inMethod'     => self::NO_QUOTE | self::NO_CLASS,
        'inTable'      => self::NO_SHORTEN,
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
        'availableUnits' => ', only %s unit(s) available',
        'inMode'         => ' in mode %s',
        'inMethod'       => ' in method %s()',
        'inData'         => ' in %s',
        'atLine'         => ' at line %s',
        'atOffset'       => ' at offset %s',
        'inPlaces'       => ' in %s',
        'atUri'          => ' at URI %s',
        'inDirectory'    => ' in directory %s',
        'inTable'        => ' in table %s',
        'forKey'         => ' for key %s',
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

                if (isset($maxLength) && mb_strlen($value) > $maxLength) {
                    return '[' . mb_substr($value, 0, $maxLength - 3) . '...]';
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
                return static::addslashes($value);

            case $flags & self::NO_SHORTEN && $flags & self::NO_CLASS:
                return '"' . static::addslashes($value) . '"';

                // prepend object type, if any, quote and shorten
            default:
                $typeLiteral = is_object($value) && !($flags & self::NO_CLASS)
                    ? '<' . get_class($value) . '>'
                    : '';

                $value = static::addslashes($value);

                if (
                    !($flags & self::NO_SHORTEN)
                    && isset($maxLength) && mb_strlen($value) > $maxLength
                ) {
                    $value = mb_substr($value, 0, $maxLength - 3) . '...';
                }

                return $typeLiteral
                    . ($flags & self::NO_QUOTE ? $value : "\"$value\"");
        }
    }

    /// Create a message from a normalized message
    public function createMessage(
        string $normalizedMessage,
        array $context
    ): string {
        $replacements = [];

        $maxLength = static::MAX_VALUE_LENGTH;

        /// Replace context values into placeholders
        foreach ($context as $placeholder => $value) {
            $replacements['{' . $placeholder . '}'] = static::value2string(
                $value,
                static::PLACEHOLDER_FLAGS[$placeholder] ?? null,
                $maxLength
            );
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

    /// Mask nonprintable characters as needed.
    public function addslashes(string $string): string
    {
        /** Always mask control characters. */
        $string = addcslashes($string, "\0..\37");

        /** Also mask non-ASCII characters if string is no valid UTF-8. The
         *  regexp is taken from [Multilingual form
         *  encoding](https://www.w3.org/International/questions/qa-forms-utf-8.en). */
        if (
            preg_match(
                '%^(?:
      [\x09\x0A\x0D\x20-\x7E]            # ASCII
    | [\xC2-\xDF][\x80-\xBF]             # non-overlong 2-byte
    | \xE0[\xA0-\xBF][\x80-\xBF]         # excluding overlongs
    | [\xE1-\xEC\xEE\xEF][\x80-\xBF]{2}  # straight 3-byte
    | \xED[\x80-\x9F][\x80-\xBF]         # excluding surrogates
    | \xF0[\x90-\xBF][\x80-\xBF]{2}      # planes 1-3
    | [\xF1-\xF3][\x80-\xBF]{3}          # planes 4-15
    | \xF4[\x80-\x8F][\x80-\xBF]{2}      # plane 16
)*$%xs',
                $string
            )
        ) {
            return $string;
        } else {
            return addcslashes($string, "\177..\377");
        }
    }
}
