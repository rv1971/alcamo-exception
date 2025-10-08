<?php

namespace alcamo\exception;

use Wikimedia\NormalizedException\INormalizedException;

/**
 * @brief Dump the details on an exceptiona s multiline text.
 *
 * Includes context and public properties.
 *
 * @date Last reviewed 2025-10-08
 */
class Dumper
{
    private $messageFactory_; ///< MessageFactoryInterface

    public function __construct(?MessageFactoryInterface $messageFactory = null)
    {
        $this->messageFactory_ = $messageFactory ?? new MessageFactory();
    }

    /// @return Multiline string with trailing newline
    public function dump(\Throwable $e): string
    {
        $result = "{$this->dumpExceptionType($e)}\n"
            . "  {$this->dumpExceptionLocation($e)}\n"
            . "  {$e->getMessage()}\n";

        if ($e instanceof INormalizedException) {
            $result .= $this->dumpMessageContext($e);
        }

        $result .= $this->dumpExceptionProps($e);

        return $result;
    }

    public function dumpExceptionType(\Throwable $e): string
    {
        return get_class($e);
    }

    public function dumpExceptionLocation(\Throwable $e): string
    {
        return "at {$e->getFile()}:{$e->getLine()}";
    }

    public function dumpMessageContext(INormalizedException $e): string
    {
        $result = '';

        foreach ($e->getMessageContext() as $key => $value) {
            $result .= "* $key = "
                . $this->messageFactory_->value2string($value)
                . "\n";
        }

        return $result;
    }

    public function dumpExceptionProps(\Throwable $e): string
    {
        $result = '';

        foreach (get_object_vars($e) as $key => $value) {
            $result .= "* $key = "
                . $this->messageFactory_->value2string($value)
                . "\n";
        }

        return $result;
    }
}
