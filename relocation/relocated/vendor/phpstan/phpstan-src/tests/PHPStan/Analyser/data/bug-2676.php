<?php

namespace TenantCloud\BetterReflection\Relocated\Bug2676;

use TenantCloud\BetterReflection\Relocated\DoctrineIntersectionTypeIsSupertypeOf\Collection;
use function TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType;
class BankAccount
{
}
/**
 * @ORM\Table
 * @ORM\Entity
 */
class Wallet
{
    /**
     * @var Collection<BankAccount>
     *
     * @ORM\OneToMany(targetEntity=BankAccount::class, mappedBy="wallet")
     * @ORM\OrderBy({"id" = "ASC"})
     */
    private $bankAccountList;
    /**
     * @return Collection<BankAccount>
     */
    public function getBankAccountList() : \TenantCloud\BetterReflection\Relocated\DoctrineIntersectionTypeIsSupertypeOf\Collection
    {
        return $this->bankAccountList;
    }
}
function (\TenantCloud\BetterReflection\Relocated\Bug2676\Wallet $wallet) : void {
    $bankAccounts = $wallet->getBankAccountList();
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('DoctrineIntersectionTypeIsSupertypeOf\\Collection&iterable<Bug2676\\BankAccount>', $bankAccounts);
    foreach ($bankAccounts as $bankAccount) {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('TenantCloud\\BetterReflection\\Relocated\\Bug2676\\BankAccount', $bankAccount);
    }
};
