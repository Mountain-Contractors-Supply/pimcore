<?php

declare(strict_types=1);

namespace App\Provider\Company;

use McSupply\EcommerceBundle\Attribute\DataProvider;
use McSupply\EcommerceBundle\Dto\Company\BranchInterface;
use McSupply\EcommerceBundle\Provider\DataProviderInterface;
use McSupply\EcommerceBundle\Provider\ReadOperationInterface;
use Pimcore\Model\DataObject\Branch;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * @implements DataProviderInterface<BranchInterface>
 * @implements ReadOperationInterface<BranchInterface>
 */
#[DataProvider(BranchInterface::class, 10)]
final readonly class PimcoreBranchProvider implements DataProviderInterface, ReadOperationInterface
{
    public function __construct(
        private RequestStack $requestStack,
    ) {}

    #[\Override]
    public function supports(string $className, array $data = []): bool
    {
        $route = $this->requestStack->getMainRequest()?->attributes->get('_route');

        return in_array(
            $route, [
                'branch_data_partial',
                'carts-ship-branch-post',
                'availability',
                'price'
            ]
        );
    }

    #[\Override]
    public function get(string $className, array $data = []): ?BranchInterface
    {
        if (!isset($data['id'])) {
            return null;
        }

        $branch = Branch::getById($data['id']);

        return $branch instanceof BranchInterface ? $branch : null;
    }
}
