<?php

/**
 * @namespace alcamo::exception
 *
 * @brief Exception classes with largely automatic message generation
 *
 * This namespace provides on the one hand some features for automatic message
 * generation which extend
 * [mediawiki-libs-NormalizedException](https://github.com/wikimedia/mediawiki-libs-NormalizedException),
 * on the other hand a hierarchy of exceptions whch make use of them. Since
 * the former are all contained the interface ExceptionInterface and the trait
 * ExceptionTrait, they can be incorporated in any given exception hierarchy.
 */

namespace alcamo\exception;

use Wikimedia\NormalizedException\INormalizedException;

/// Provide setMessageContext()
interface ExceptionInterface extends INormalizedException
{
    public function setMessageContext(array $context): self;
}
