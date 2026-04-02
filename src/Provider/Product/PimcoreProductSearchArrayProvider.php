<?php

declare(strict_types=1);

namespace App\Provider\Product;

use McSupply\EcommerceBundle\Attribute\DataProvider;
use McSupply\EcommerceBundle\Dto\Product\ProductSearch;
use McSupply\EcommerceBundle\Dto\Product\ProductSearchArray;
use McSupply\EcommerceBundle\Provider\DataProviderInterface;
use McSupply\EcommerceBundle\Provider\ReadOperationInterface;
use Pimcore\Model\DataObject\Product;

/**
 * @implements DataProviderInterface<ProductSearchArray>
 * @implements ReadOperationInterface<ProductSearchArray>
 */
#[DataProvider(ProductSearchArray::class, 10)]
final readonly class PimcoreProductSearchArrayProvider implements DataProviderInterface, ReadOperationInterface
{
    public function supports(string $className, array $data = []): bool
    {
        return true;
    }

    public function get(string $className, array $data = []): ProductSearchArray
    {
        $id = $data['id'] ?? null;
        $query = $data['q'] ?? null;
        $listing = new Product\Listing();
        $listing->setLimit(5);
        $conditions = [];
        $params = [];

        if ($id !== null) {
            $conditions[] = 'oo_id IN (SELECT src_id FROM object_relations_product WHERE dest_id = ? AND fieldname = ?)';
            $params[] = $id;
            $params[] = 'categoriesRef';
        }

        if (!empty($query)) {
            $conditions[] = '(name LIKE ?)';
            $like = '%' . $query . '%';
            $params[] = $like;
        }

        $listing->setCondition(
            implode(' AND ', $conditions),
            $params
        );

        $products = new ProductSearchArray();

        foreach ($listing as $product) {
            $products->add(
                (new ProductSearch($product->getName()))
            );
        }

        return $products;
    }
}
