<?php

declare(strict_types=1);

namespace App\Provider;

use Exception;
use McSupply\EcommerceBundle\Attribute\DataProvider;
use McSupply\EcommerceBundle\Provider\DataProviderInterface;
use McSupply\EcommerceBundle\Dto\Company\BranchInterface;
use McSupply\EcommerceBundle\Resolver\DefaultDataResolver;
use Pimcore\Model\DataObject\Branch;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * @implements DataProviderInterface<BranchInterface>
 */
#[DataProvider(BranchInterface::class, DefaultDataResolver::class, 10)]
final readonly class PimcoreBranchProvider implements DataProviderInterface
{
    public function __construct(
        private RequestStack $requestStack,
    ) {}

    /**
     * @inheritDoc
     */
    #[\Override]
    public function supports(string $className, mixed $data = null): bool
    {
        return $this->requestStack->getMainRequest()?->attributes->get('_route') === 'branch_data_partial';
    }

    /**
     * @inheritDoc
     */
    #[\Override]
    public function get(string $className, mixed $data = null): ?BranchInterface
    {
        if (!isset($data['id'])) {
            return null;
        }

        $branch = Branch::getById($data['id']);

        return $branch instanceof BranchInterface ? $branch : null;
    }

    /**
     * @param Branch $dto
     * @inheritDoc
     * @throws Exception
     */
    #[\Override]
    public function save(mixed $dto, mixed $data = null): void
    {
        $dto->save();
    }
}
