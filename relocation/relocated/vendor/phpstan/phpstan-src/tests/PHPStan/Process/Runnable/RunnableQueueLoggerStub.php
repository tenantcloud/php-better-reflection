<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Process\Runnable;

class RunnableQueueLoggerStub implements \TenantCloud\BetterReflection\Relocated\PHPStan\Process\Runnable\RunnableQueueLogger
{
    /** @var string[] */
    private $messages = [];
    /**
     * @return string[]
     */
    public function getMessages() : array
    {
        return $this->messages;
    }
    public function log(string $message) : void
    {
        $this->messages[] = $message;
    }
}
