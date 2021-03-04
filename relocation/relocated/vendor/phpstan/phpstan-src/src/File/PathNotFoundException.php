<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\File;

class PathNotFoundException extends \Exception
{
    private string $path;
    public function __construct(string $path)
    {
        parent::__construct(\sprintf('Path %s does not exist', $path));
        $this->path = $path;
    }
    public function getPath() : string
    {
        return $this->path;
    }
}
