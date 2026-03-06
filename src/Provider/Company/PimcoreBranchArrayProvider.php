<?php

declare(strict_types=1);

namespace App\Provider\Company;

use Exception;
use McSupply\EcommerceBundle\Attribute\DataProvider;
use McSupply\EcommerceBundle\Dto\Company\BranchArray;
use McSupply\EcommerceBundle\Provider\DataProviderInterface;
use McSupply\EcommerceBundle\Provider\ReadOperationInterface;
use Pimcore\Model\DataObject\Branch;

/**
 * @implements DataProviderInterface<BranchArray>
 * @implements ReadOperationInterface<BranchArray>
 */
#[DataProvider(BranchArray::class, 10)]
class PimcoreBranchArrayProvider implements DataProviderInterface, ReadOperationInterface
{
    #[\Override]
    public function supports(string $className, mixed $data = null): bool
    {
        return true;
    }

    /**
     * @throws Exception
     */
    #[\Override]
    public function get(string $className, mixed $data = null): BranchArray
    {
        $branches = new BranchArray();

        foreach (Branch::getList() as $branch) {
            if (!$branch) {
                continue;
            }

            $branches->add($branch, (string)$branch->getId());
        }

        return $branches;
    }
}
