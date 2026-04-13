<?php

declare(strict_types=1);

namespace App\Provider\Product;

use App\Dto\Product\ProductSearchArray;
use McSupply\EcommerceBundle\Attribute\DataProvider;
use McSupply\EcommerceBundle\Provider\DataProviderInterface;
use McSupply\EcommerceBundle\Provider\ReadOperationInterface;
use Pimcore\Bundle\GenericDataIndexBundle\Model\Search\Modifier\QueryLanguage\PqlFilter;
use Pimcore\Bundle\GenericDataIndexBundle\Service\Search\SearchService\DataObject\DataObjectSearchServiceInterface;
use Pimcore\Bundle\GenericDataIndexBundle\Service\Search\SearchService\SearchProviderInterface;

/**
 * @implements DataProviderInterface<ProductSearchArray>
 * @implements ReadOperationInterface<ProductSearchArray>
 */
#[DataProvider(ProductSearchArray::class, 10)]
final readonly class ProductSearchArrayProvider implements DataProviderInterface, ReadOperationInterface
{
    public function __construct(
        private SearchProviderInterface $searchProvider,
        private DataObjectSearchServiceInterface $dataObjectSearchService,
    ) {}

    public function supports(string $className, array $data = []): bool
    {
        return true;
    }

    public function get(string $className, array $data = []): ProductSearchArray
    {
        $dataObjectSearch = $this->searchProvider->createDataObjectSearch();
        $dataObjectSearch->setPageSize($data['limit']);

        // TODO: Extract this to an independent service so it can be used for auto complete and search listings
        if (!empty($data['q'])) {
            $words = array_filter(explode(' ', trim((string)$data['q'])));
            $clauses = [];

            foreach ($words as $w) {
                $wEscaped = addcslashes($w, '"'); // minimal escaping for quotes
                // per-word boosts:
                // - exact/phrase (highest): "word"^6
                // - prefix/wildcard (medium): word*^4
                // - fuzzy (low): word~1^1
                $clauses[] = sprintf('(" %1$s " ^6) OR (%1$s* ^4) OR (%1$s~1 ^1)', $wEscaped);
            }
            $queryString = implode(' ', $clauses);
            $dataObjectSearch->addModifier(
                new PqlFilter(sprintf('Query("standard_fields.name.en_US:(%s)")', $queryString))
            );
        }

        $dataObjectSearch->addModifier(
            new PqlFilter("custom_fields.category_ids = {$data['id']}")
        );
        $searchResult = $this->dataObjectSearchService->search($dataObjectSearch);

        return new ProductSearchArray($searchResult->getItems());
    }
}
