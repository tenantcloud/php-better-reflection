<?php

namespace TenantCloud\BetterReflection\Relocated\Bug2676ReturnTypeRule;

use TenantCloud\BetterReflection\Relocated\DoctrineIntersectionTypeIsSupertypeOf\Collection;
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
