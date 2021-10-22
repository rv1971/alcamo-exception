<?php

namespace alcamo\exception;

use Wikimedia\NormalizedException\NormalizedExceptionTrait;

/**
 * @brief Trait common to all exceptions in this namespace
 */
trait ExceptionTrait
{
    use NormalizedExceptionTrait;

    /// Create from previous exception, using contents of previous
    public static function newFromPrevious(
        \Throwable $previous,
        ?array $context
    ): self {
        return new static(
            null,
            $previous->getCode(),
            $previous,
            (array)$context + [ 'extraMessage' => $previous->getMessage() ]
        );
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

    /**
     * @brief Set @ref messageContext
     *
     * Then rebuild the denormalized message and return $this.
     */
    public function setMessageContext(array $context): ExceptionInterface
    {
        $this->messageContext = $context;

        if (defined('static::DEFAULT_MESSAGE_CONTEXT')) {
            $this->messageContext += static::DEFAULT_MESSAGE_CONTEXT;
        }

        $this->rebuildMessage();

        return $this;
    }

    /**
     * @brief Add data to @ref messageContext
     *
     * Existing data in @ref messageContext may be overwritten.
     *
     * Then rebuild the denormalized message and return $this.
     */
    public function addMessageContext(array $context): ExceptionInterface
    {
        $this->messageContext = $context + $this->messageContext;

        $this->rebuildMessage();

        return $this;
    }

    /// Rebuild the denormalized message
    protected function rebuildMessage(): void
    {
        $this->message = (new MessageBuilder())->normalizedMessage2Message(
            $this->normalizedMessage,
            $this->messageContext
        );
    }
}
