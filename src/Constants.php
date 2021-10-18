<?php

namespace alcamo\exception;

/// Constants needed in ExceptionTrait
class Constants
{
    /// Maximum length of values when replaced into messages
    public const MAX_VALUE_LENGTH = 40;

    /// Default data for message context
    public const DEFAULT_MESSAGE_CONTEXT = [];

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
        'inMethod'       => ' in method %s',
        'inData'         => ' in %s',
        'atLine'         => ' at line %s',
        'atOffset'       => ' at offset %s',
        'inPlaces'       => ' in %s',
        'atUri'          => ' at URI %s',
        'extraMessage'   => '; %s'
    ];
}
