<?php

declare(strict_types=1);

namespace App\Provider\Product;

use McSupply\EcommerceBundle\Attribute\DataProvider;
use McSupply\EcommerceBundle\Provider\DataProviderInterface;
use McSupply\EcommerceBundle\Provider\ReadOperationInterface;
use Pimcore\Model\DataObject\Product\Listing;

/**
 * @implements DataProviderInterface<Listing>
 * @implements ReadOperationInterface<Listing>
 */
#[DataProvider(Listing::class)]
final readonly class PimcoreProductListingBuilderProvider implements DataProviderInterface, ReadOperationInterface
{
    public function supports(string $className, array $data = []): bool
    {
        return true;
    }

    public function get(string $className, array $data = []): ?Listing
    {
        $id = $data['id'] ?? null;
        $query = $data['q'] ?? null;

        if ($id === null && empty($query)) {
            return null;
        }

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

        return (new Listing())->setCondition(
            implode(' AND ', $conditions),
            $params
        );
    }
}
