<?php

declare(strict_types=1);

namespace App\Provider\Product;

use McSupply\EcommerceBundle\Attribute\DataProvider;
use McSupply\EcommerceBundle\Dto\OnlineStore\OnlineStoreInterface;
use McSupply\EcommerceBundle\Dto\Product\ProductCategoryArray;
use McSupply\EcommerceBundle\Dto\Product\ProductCategoryInterface;
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

    #[\Override]
    public function supports(string $className, array $data = []): bool
    {
        return true;
    }

    #[\Override]
    public function get(string $className, array $data = []): ProductCategoryArray
    {
        $categories = new ProductCategoryArray();
        $category = $this->dataResolver->get(OnlineStoreInterface::class)->getRootProductCategory();
        $listing = (new ProductCategory\Listing())
            ->setCondition('parentId = ?', [$category->getId()])
            ->setOrderKey('name');

        foreach ($listing as $item) {
            $categories->add($item);
        }

        return $categories; 
    }
}