<?php

declare(strict_types=1);

namespace App\Provider\Company;

use McSupply\EcommerceBundle\Dto\Company\AccountInterface;
use McSupply\EcommerceBundle\Dto\User\CustomerInterface;
use McSupply\EcommerceBundle\Provider\Company\AccountProviderInterface;
use McSupply\EcommerceBundle\Provider\OnlineStore\OnlineStoreProviderInterface;
use Pimcore\Model\DataObject\Account;
use Symfony\Bundle\SecurityBundle\Security;

final readonly class AccountProvider implements AccountProviderInterface
{
    public function __construct(
        private OnlineStoreProviderInterface $onlineStoreProvider,
        private Security                     $security,
    )
    {
    }

    /**
     * @inheritDoc
     */
    #[\Override]
    public function getValidShipTos(): array
    {
        $validShipTos = [];
        $customer = $this->security->getUser();

        if ($customer instanceof CustomerInterface) {
            $onlineStore = $this->onlineStoreProvider->getOnlineStore();
            $accounts = $customer->getAccounts();

            foreach ($accounts as $account) {
                if (in_array($onlineStore?->getId(), $account->getValidOnlineStoreIds())) {
                    $validShipTos[$account->getAccountId()] = $account;
                }
            }
        }

        return $validShipTos;
    }

    /**
     * @inheritDoc
     */
    #[\Override]
    public function isValidShipTo(string $accountId): bool
    {
        return isset($this->getValidShipTos()[$accountId]);
    }

    /**
     * @inheritDoc
     */
    #[\Override]
    public function getAccount(string $accountId): ?AccountInterface
    {
        $account = Account::getByAccountId($accountId, 1);

        return $account instanceof AccountInterface ? $account : null;
    }
}
