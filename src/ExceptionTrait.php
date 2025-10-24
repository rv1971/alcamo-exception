<?php

namespace alcamo\exception;

use Wikimedia\NormalizedException\NormalizedExceptionTrait;

/**
 * @brief Trait common to all exceptions in this namespace
 */
trait ExceptionTrait
{
    use NormalizedExceptionTrait;

    protected $messageFactory_; ///< MessageFactoryInterface

    /// Create from previous exception, using contents of previous
    public static function newFromPrevious(
        \Throwable $previous,
        ?array $context = null,
        ?MessageFactoryInterface $messageFactory = null
    ): self {
        return new static(
            null,
            $previous->getCode(),
            $previous,
            (array)$context + [ 'extraMessage' => $previous->getMessage() ],
            $messageFactory
        );
    }

    public function __construct(
        ?string $normalizedMessage = null,
        int $code = 0,
        \Throwable $previous = null,
        array $context = [],
        ?MessageFactoryInterface $messageFactory = null
    ) {
        $this->normalizedMessage =
            $normalizedMessage ?? static::NORMALIZED_MESSAGE;

        parent::__construct('', $code, $previous);

        $this->setMessageContext(
            $context,
            $messageFactory ?? new MessageFactory()
        );
    }

    /** @copydoc alcamo::exception::ExceptionInterface::setMessageContext() */
    public function setMessageContext(
        array $context,
        ?MessageFactoryInterface $messageFactory = null
    ): ExceptionInterface {
        if (isset($messageFactory)) {
            $this->messageFactory_ = $messageFactory;
        }

        $this->messageContext = $context;

        if (defined('static::DEFAULT_MESSAGE_CONTEXT')) {
            $this->messageContext += static::DEFAULT_MESSAGE_CONTEXT;
        }

        $this->message = $this->messageFactory_->createMessage(
            $this->normalizedMessage,
            $this->messageContext
        );

        return $this;
    }

    /** @copydoc alcamo::exception::ExceptionInterface::addMessageContext() */
    public function addMessageContext(
        array $context,
        ?MessageFactoryInterface $messageFactory = null
    ): ExceptionInterface {
        if (isset($messageFactory)) {
            $this->messageFactory_ = $messageFactory;
        }

        $this->messageContext = $context + $this->messageContext;

        $this->message = $this->messageFactory_->createMessage(
            $this->normalizedMessage,
            $this->messageContext
        );

        return $this;
    }
}
