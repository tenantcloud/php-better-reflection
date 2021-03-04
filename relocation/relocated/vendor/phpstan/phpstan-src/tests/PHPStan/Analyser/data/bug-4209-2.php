<?php

namespace TenantCloud\BetterReflection\Relocated\Bug4209Two;

use function TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType;
class Customer
{
    public function getName() : string
    {
        return 'customer';
    }
}
/**
 * @template T
 */
interface Link
{
    /**
     * @return T
     */
    public function getItem();
}
/**
 * @implements Link<Customer>
 */
class CustomerLink implements \TenantCloud\BetterReflection\Relocated\Bug4209Two\Link
{
    /**
     * @var Customer
     */
    public $item;
    /**
     * @param Customer $item
     */
    public function __construct($item)
    {
        $this->item = $item;
    }
    /**
     * @return Customer
     */
    public function getItem()
    {
        return $this->item;
    }
}
/**
 * @return CustomerLink[]
 */
function get_links() : array
{
    return [new \TenantCloud\BetterReflection\Relocated\Bug4209Two\CustomerLink(new \TenantCloud\BetterReflection\Relocated\Bug4209Two\Customer())];
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
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('TenantCloud\\BetterReflection\\Relocated\\Bug4209Two\\Customer', process_customers(get_links()));
    }
}
