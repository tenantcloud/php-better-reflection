<?php

namespace TenantCloud\BetterReflection\Relocated\Bug4084;

class Handler implements \SessionUpdateTimestampHandlerInterface
{
    /**
     * @param string $sessionId
     * @param string $data
     */
    public function updateTimestamp($sessionId, $data)
    {
        return \true;
    }
    /**
     * @param string $sessionId The session id
     */
    public function validateId($sessionId)
    {
        return \true;
    }
}
