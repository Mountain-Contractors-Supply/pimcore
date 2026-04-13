<?php

declare(strict_types=1);

namespace App\Provider\Product;

use App\LinkGenerator\ProductLinkGenerator;
use McSupply\EcommerceBundle\Attribute\DataProvider;
use McSupply\EcommerceBundle\Dto\Product\ProductSearch;
use McSupply\EcommerceBundle\Dto\Product\ProductSearchArray;
use McSupply\EcommerceBundle\Provider\DataProviderInterface;
use McSupply\EcommerceBundle\Provider\DataResolverAwareInterface;
use McSupply\EcommerceBundle\Provider\DataResolverAwareTrait;
use McSupply\EcommerceBundle\Provider\ReadOperationInterface;
use Pimcore\Model\DataObject\Product;

/**
 * @implements DataProviderInterface<ProductSearchArray>
 * @implements ReadOperationInterface<ProductSearchArray>
 */
#[DataProvider(ProductSearchArray::class, 10)]
final class PimcoreProductSearchArrayProvider implements DataProviderInterface, ReadOperationInterface, DataResolverAwareInterface
{
    use DataResolverAwareTrait;

    public function __construct(
        private readonly ProductLinkGenerator $productLinkGenerator,
    ) {}

    public function supports(string $className, array $data = []): bool
    {
        return true;
    }

    public function get(string $className, array $data = []): ProductSearchArray
    {
        $listing = $this->dataResolver->get(Product\Listing::class, $data);
        $listing->setLimit(5);
        $products = new ProductSearchArray();

        foreach ($listing as $product) {
            if ($product) {
                $products->add(
                    new ProductSearch(
                        (string)$product->getName(),
                        '',
                        $this->productLinkGenerator->generate($product),
                    )
                );
            }
        }

        return $products;
    }
}
