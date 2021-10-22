<?php

namespace alcamo\exception;

/// Constants needed in ExceptionTrait
class Constants
{
    /// Maximum length of values when replaced into messages
    public const MAX_VALUE_LENGTH = 40;

    /// Default data for message context
    public const DEFAULT_MESSAGE_CONTEXT = [];

    public const NO_QUOTE   = 1; ///< Do not quote a string literal
    public const NO_SHORTEN = 2; ///< Do not shorten a string literal

    /// Flags for ExceptionTrait::value2string()
    public const PLACEHOLDER_FLAGS = [
        'atUri'        => self::NO_SHORTEN,
        'extraMessage' => self::NO_QUOTE | self::NO_SHORTEN,
        'inMethod'     => self::NO_QUOTE,
        'objectType'   => self::NO_QUOTE | self::NO_SHORTEN
    ];

    /**
     * @brief Fragments that may be automaticaly appended to the message
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
}
