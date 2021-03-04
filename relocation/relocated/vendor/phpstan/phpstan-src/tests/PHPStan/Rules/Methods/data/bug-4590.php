<?php

namespace TenantCloud\BetterReflection\Relocated\Bug4590;

/**
 * @template T
 */
class OkResponse
{
    /**
     * @phpstan-var T
     */
    private $body;
    /**
     * @phpstan-param T $body
     */
    public function __construct($body)
    {
        $this->body = $body;
    }
    /**
     * @phpstan-return T
     */
    public function getBody()
    {
        return $this->body;
    }
}
class Controller
{
    /**
     * @return OkResponse<array<string, string>>
     */
    public function test1() : \TenantCloud\BetterReflection\Relocated\Bug4590\OkResponse
    {
        return new \TenantCloud\BetterReflection\Relocated\Bug4590\OkResponse(["ok" => "hello"]);
    }
    /**
     * @return OkResponse<array<int, string>>
     */
    public function test2() : \TenantCloud\BetterReflection\Relocated\Bug4590\OkResponse
    {
        return new \TenantCloud\BetterReflection\Relocated\Bug4590\OkResponse([0 => "hello"]);
    }
    /**
     * @return OkResponse<string[]>
     */
    public function test3() : \TenantCloud\BetterReflection\Relocated\Bug4590\OkResponse
    {
        return new \TenantCloud\BetterReflection\Relocated\Bug4590\OkResponse(["hello"]);
    }
    /**
     * @return OkResponse<string>
     */
    public function test4() : \TenantCloud\BetterReflection\Relocated\Bug4590\OkResponse
    {
        return new \TenantCloud\BetterReflection\Relocated\Bug4590\OkResponse("hello");
    }
    /**
     * @param array<int, string> $a
     * @return OkResponse<array<int, string>>
     */
    public function test5(array $a) : \TenantCloud\BetterReflection\Relocated\Bug4590\OkResponse
    {
        return new \TenantCloud\BetterReflection\Relocated\Bug4590\OkResponse($a);
    }
}
