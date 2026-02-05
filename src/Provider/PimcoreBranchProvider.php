<?php

declare(strict_types=1);

namespace App\Provider;

use Exception;
use McSupply\EcommerceBundle\Attribute\DataProvider;
use McSupply\EcommerceBundle\Provider\DataProviderInterface;
use McSupply\EcommerceBundle\Dto\Company\BranchInterface;
use McSupply\EcommerceBundle\Resolver\DefaultDataResolver;
use Pimcore\Model\DataObject\Branch;

/**
 * @implements DataProviderInterface<BranchInterface>
 */
#[DataProvider(BranchInterface::class, DefaultDataResolver::class, 10)]
class PimcoreBranchProvider implements DataProviderInterface
{
    /**
     * @inheritDoc
     */
    #[\Override]
    public function supports(string $className, mixed $data = null): bool
    {
        return true;
    }

    /**
     * @inheritDoc
     */
    #[\Override]
    public function get(string $className, mixed $data = null): ?BranchInterface
    {
        if (!isset($data['branchId'])) {
            return null;
        }

        $branch = Branch::getById($data['branchId']);

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
