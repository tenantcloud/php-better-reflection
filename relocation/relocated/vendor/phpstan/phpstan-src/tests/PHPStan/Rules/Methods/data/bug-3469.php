<?php

namespace TenantCloud\BetterReflection\Relocated\Bug3469;

abstract class Tile
{
    protected abstract function readSaveData() : void;
    protected abstract function writeSaveData() : void;
}
abstract class Spawnable extends \TenantCloud\BetterReflection\Relocated\Bug3469\Tile
{
}
trait NameableTrait
{
    protected function loadName() : void
    {
    }
    protected function saveName() : void
    {
    }
}
class EnchantTable extends \TenantCloud\BetterReflection\Relocated\Bug3469\Spawnable
{
    use NameableTrait {
        loadName as readSaveData;
        saveName as writeSaveData;
    }
}
