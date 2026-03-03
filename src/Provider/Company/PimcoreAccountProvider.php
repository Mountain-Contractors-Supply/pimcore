<?php

declare(strict_types=1);

namespace App\Provider\Company;

use Exception;
use McSupply\EcommerceBundle\Attribute\DataProvider;
use McSupply\EcommerceBundle\Dto\Company\AccountInterface;
use McSupply\EcommerceBundle\Provider\DataProviderInterface;
use McSupply\EcommerceBundle\Resolver\DefaultDataResolver;
use Pimcore\Model\DataObject\Account;

/**
 * @implements DataProviderInterface<Account>
 */
#[DataProvider(AccountInterface::class, DefaultDataResolver::class, 10)]
final readonly class PimcoreAccountProvider implements DataProviderInterface
{
    /**
     * @inheritDoc
     */
    #[\Override]
    public function supports(string $className, mixed $data = null): bool
    {
        // TODO: Implement properly once we need something other than the default hydrator
        return false;
    }

    /**
     * @inheritDoc
     */
    #[\Override]
    public function get(string $className, mixed $data = null): ?AccountInterface
    {
        if (!isset($data['accountId'])) {
            return null;
        }

        $account = Account::getByAccountId($data['accountId'], 1);

        return $account instanceof Account ? $account : null;
    }

    /**
     * @inheritDoc
     *
     * @throws Exception
     */
    #[\Override]
    public function save(mixed $dto, mixed $data = null): void
    {
        $dto->save();
    }
}
