<?php

namespace TenantCloud\BetterReflection\Relocated\Bug4209;

use function TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType;
/**
 * @template T
 */
class Link
{
    /**
     * @var T
     */
    public $item;
    /**
     * @param T $item
     */
    public function __construct($item)
    {
        $this->item = $item;
    }
}
class Customer
{
    public function getName() : string
    {
        return 'customer';
    }
}
/**
 * @return Link<Customer>[]
 */
function get_links() : array
{
    return [new \TenantCloud\BetterReflection\Relocated\Bug4209\Link(new \TenantCloud\BetterReflection\Relocated\Bug4209\Customer())];
}
/**
 * @template T
 * @param Link<T>[] $links
 * @return T
 */
function process_customers(array $links)
{
    // no-op
}
class Runner
{
    public function run() : void
    {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('TenantCloud\\BetterReflection\\Relocated\\Bug4209\\Customer', process_customers(get_links()));
    }
}
