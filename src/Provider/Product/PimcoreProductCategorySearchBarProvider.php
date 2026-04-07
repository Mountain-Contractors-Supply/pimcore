<?php

declare(strict_types=1);

namespace App\Provider\Product;

use Doctrine\DBAL\Query\QueryBuilder;
use McSupply\EcommerceBundle\Attribute\DataProvider;
use McSupply\EcommerceBundle\Dto\OnlineStore\OnlineStoreInterface;
use McSupply\EcommerceBundle\Dto\Product\ProductCategoryArray;
use McSupply\EcommerceBundle\Provider\DataProviderInterface;
use McSupply\EcommerceBundle\Provider\DataResolverAwareInterface;
use McSupply\EcommerceBundle\Provider\DataResolverAwareTrait;
use McSupply\EcommerceBundle\Provider\ReadOperationInterface;
use Pimcore\Model\DataObject\ProductCategory;

/**
 * @implements DataProviderInterface<ProductCategoryArray>
 * @implements ReadOperationInterface<ProductCategoryArray>
 */
#[DataProvider(ProductCategoryArray::class, 10)]
final class PimcoreProductCategorySearchBarProvider implements DataProviderInterface, ReadOperationInterface, DataResolverAwareInterface
{
    use DataResolverAwareTrait;

    public function supports(string $className, array $data = []): bool
    {
        return true;
    }

    public function get(string $className, array $data = []): ProductCategoryArray
    {
        $categoryId = $this->dataResolver->get(OnlineStoreInterface::class)->getRootProductCategory()->getId();
        $listing = (new ProductCategory\Listing())
            ->setCondition('parentId = ? OR id IN (?, ?)', [
                $categoryId,
                $data['id'],
                $categoryId,
            ]);

        $listing->onCreateQueryBuilder(
            function (QueryBuilder $qb) use ($categoryId) {
                $qb->resetOrderBy();
                $customOrder = "CASE
                    WHEN id = " . $categoryId . " THEN 1
                    WHEN parentId <> " . $categoryId . " THEN 0
                    ELSE 2
                END";

                // Use addOrderBy to ensure this happens FIRST
                $qb->addOrderBy($customOrder, 'ASC');
                $qb->addOrderBy('name', 'ASC');
            }
        );

        return new ProductCategoryArray($listing);
    }
}
