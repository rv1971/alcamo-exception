<?php

/**
 * @namespace alcamo::exception
 *
 * @brief Exception classes with largely automatic message generation
 *
 * This namespace provides on the one hand some features for automatic message
 * generation which extend
 * [mediawiki-libs-NormalizedException](https://github.com/wikimedia/mediawiki-libs-NormalizedException),
 * on the other hand a hierarchy of exceptions which make use of them. Since
 * the former are all contained the interface ExceptionInterface and the trait
 * ExceptionTrait, they can be incorporated in any given exception hierarchy.
 *
 * @date Last reviewed 2025-10-07
 */

namespace alcamo\exception;

use Wikimedia\NormalizedException\INormalizedException;

/**
 * @brief Require, among others, setMessageContext()
 *
 * Derived classes MUST define a class constant `NORMALIZED_MESSAGE` (see )
 * and MAY define class constant `DEFAULT_MESSAGE_CONTEXT` (see
 * AbstractObjectStateException).
 *
 * @date Last reviewed 2025-10-24
 */
interface ExceptionInterface extends INormalizedException
{
    /**
     * @brief Set the message context
     *
     * Replace any preceding context. Then rebuild the denormalized
     * message and return $this.
     */
    public function setMessageContext(array $context): self;

    /**
     * @brief Add data to the message context
     *
     * Overwrite any existing keys with new ones. Then rebuild the
     * denormalized message and return $this.
     */
    public function addMessageContext(array $context): self;
}
