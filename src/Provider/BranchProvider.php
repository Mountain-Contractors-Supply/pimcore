<?php

declare(strict_types=1);

namespace App\Provider;

use Exception;
use McSupply\EcommerceBundle\Dto\Company\BranchInterface;
use McSupply\EcommerceBundle\Provider\BranchProviderInterface;
use McSupply\EcommerceBundle\Provider\OnlineStoreProviderInterface;
use Pimcore\Model\DataObject\Branch;

final readonly class BranchProvider implements BranchProviderInterface
{
    public function __construct(
        private OnlineStoreProviderInterface $onlineStoreProvider,
    )
    {
    }

    /**
     * @inheritDoc
     */
    #[\Override]
    public function getLocationCount(): array
    {
        try {
            return $this->getBranchCount(Branch::getList()->getData());
        } catch (Exception) {
            //TODO: Potentially log the error here?
            return [
                'branchCount' => 0,
                'stateCount' => 0,
            ];
        }
    }

    /**
     * @inheritDoc
     */
    #[\Override]
    public function getValidBranches(?int $onlineStoreId = null): array
    {
        try {
            return $this->onlineStoreProvider->filterBranches(Branch::getList()->getData());
        } catch (Exception) {
            //TODO: Potentially log the error here?
            return [];
        }
    }

    /**
     * @inheritDoc
     */
    #[\Override]
    public function getBranches(): array
    {
        try {
            return Branch::getList()->getData();
        } catch (Exception) {
            //TODO: Potentially log the error here?
            return [];
        }
    }

    /**
     * @inheritDoc
     */
    #[\Override]
    public function isValidShipBranch(int $branchId): bool
    {
        return isset($this->getValidBranches()[$branchId]);
    }

    /**
     * @param BranchInterface[] $branches
     * @return array{branchCount: int, stateCount: int}
     */
    private function getBranchCount(array $branches): array
    {
        $branchCount = 0;
        $states = [];

        foreach ($branches as $branch) {
            if ($state = $branch->getAddress()?->getState()) {
                $states[] = $state;
            }

            $branchCount++;
        }

        return [
            'branchCount' => $branchCount,
            'stateCount' => count(array_unique($states)),
        ];
    }
}
