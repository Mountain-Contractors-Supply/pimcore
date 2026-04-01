<?php

declare(strict_types=1);

namespace App\Provider\Company;

use McSupply\EcommerceBundle\Attribute\DataProvider;
use McSupply\EcommerceBundle\Dto\Company\AccountInterface;
use McSupply\EcommerceBundle\Provider\DataProviderInterface;
use McSupply\EcommerceBundle\Provider\ReadOperationInterface;
use Pimcore\Model\DataObject\Account;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * @implements DataProviderInterface<AccountInterface>
 * @implements ReadOperationInterface<AccountInterface>
 */
#[DataProvider(AccountInterface::class, 10)]
final readonly class PimcoreAccountProvider implements DataProviderInterface, ReadOperationInterface
{
    public function __construct(
        private RequestStack $requestStack,
    ) {}

    #[\Override]
    public function supports(string $className, array $data = []): bool
    {
        $route = $this->requestStack->getMainRequest()?->attributes->get('_route');

        return str_starts_with($route, 'checkout');
    }

    #[\Override]
    public function get(string $className, array $data = []): ?AccountInterface
    {
        if (!isset($data['accountId'])) {
            return null;
        }

        $account = Account::getByAccountId($data['accountId'], 1);

        return $account instanceof Account ? $account : null;
    }
}
