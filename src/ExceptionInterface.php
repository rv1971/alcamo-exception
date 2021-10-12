<?php

namespace alcamo\exception;

use Wikimedia\NormalizedException\INormalizedException;

interface ExceptionInterface extends INormalizedException
{
    public function setMessageContext(array $context): self;
}
