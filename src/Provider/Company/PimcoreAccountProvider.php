<?php

declare(strict_types=1);

namespace App\Provider\Company;

use McSupply\EcommerceBundle\Attribute\DataProvider;
use McSupply\EcommerceBundle\Dto\Company\AccountInterface;
use McSupply\EcommerceBundle\Provider\DataProviderInterface;
use McSupply\EcommerceBundle\Provider\ReadOperationInterface;
use Pimcore\Model\DataObject\Account;

/**
 * @implements DataProviderInterface<AccountInterface>
 * @implements ReadOperationInterface<AccountInterface>
 */
#[DataProvider(AccountInterface::class, 10)]
final readonly class PimcoreAccountProvider implements DataProviderInterface, ReadOperationInterface
{
    #[\Override]
    public function supports(string $className, mixed $data = null): bool
    {
        // TODO: Implement properly once we need something other than the default hydrator
        return false;
    }

    #[\Override]
    public function get(string $className, mixed $data = null): ?AccountInterface
    {
        if (!isset($data['accountId'])) {
            return null;
        }

        $account = Account::getByAccountId($data['accountId'], 1);

        return $account instanceof Account ? $account : null;
    }
}
