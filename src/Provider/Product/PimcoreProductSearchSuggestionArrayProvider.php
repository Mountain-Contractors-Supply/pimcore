<?php

declare(strict_types=1);

namespace App\Provider\Product;

use App\LinkGenerator\ProductLinkGenerator;
use McSupply\EcommerceBundle\Attribute\DataProvider;
use McSupply\EcommerceBundle\Dto\OnlineStore\OnlineStoreInterface;
use McSupply\EcommerceBundle\Dto\Product\ProductSearch;
use McSupply\EcommerceBundle\Dto\Product\ProductSearchSuggestionArray;
use McSupply\EcommerceBundle\Provider\DataProviderInterface;
use McSupply\EcommerceBundle\Provider\DataResolverAwareInterface;
use McSupply\EcommerceBundle\Provider\DataResolverAwareTrait;
use McSupply\EcommerceBundle\Provider\ReadOperationInterface;
use Pimcore\Bundle\GenericDataIndexBundle\Model\Search\Modifier\QueryLanguage\PqlFilter;
use Pimcore\Bundle\GenericDataIndexBundle\Service\Search\SearchService\DataObject\DataObjectSearchServiceInterface;
use Pimcore\Bundle\GenericDataIndexBundle\Service\Search\SearchService\SearchProviderInterface;
use Pimcore\Model\DataObject\Product;
use Pimcore\Model\DataObject\ProductCategory;

/**
 * @implements DataProviderInterface<ProductSearchSuggestionArray>
 * @implements ReadOperationInterface<ProductSearchSuggestionArray>
 */
#[DataProvider(ProductSearchSuggestionArray::class, 10)]
final class PimcoreProductSearchSuggestionArrayProvider implements DataProviderInterface, ReadOperationInterface, DataResolverAwareInterface
{
    use DataResolverAwareTrait;

    public function __construct(
        private readonly ProductLinkGenerator $productLinkGenerator,
        private readonly SearchProviderInterface $searchProvider,
        private readonly DataObjectSearchServiceInterface $dataObjectSearchService
    ) {}

    public function supports(string $className, array $data = []): bool
    {
        return true;
    }

    public function get(string $className, array $data = []): ProductSearchSuggestionArray
    {
        $dataObjectSearch = $this->searchProvider->createDataObjectSearch();
        $dataObjectSearch->setPageSize(6);

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
        $items = $searchResult->getItems();

        /** @var OnlineStoreInterface $onlineStore */
        $onlineStore = $this->dataResolver->get(OnlineStoreInterface::class);

        /** @var ProductCategory $rootCategory */
        $rootCategory = $onlineStore->getRootProductCategory();
        $path = $rootCategory->getPath() . $rootCategory->getKey() . '/';
        $productCategoryGenerator = (function () use ($items, $data, $path): \Generator {
            foreach ($items as $item) {
                $customFields = $item->getSearchIndexData();
                $category = ProductCategory::getById($customFields['custom_fields']['category_ids'][0]);
                $name = str_replace([$path, '/'], ['', ' > '], (string)$category?->getPath());

                yield new ProductSearch(
                    $customFields['standard_fields']['name']['en_US'],
                    '',
                    $this->productLinkGenerator->generate(
                        (new Product())
                            ->setProductId($customFields['standard_fields']['productId'])
                            ->setName($customFields['standard_fields']['name']['en_US']),
                    ),
                    $name . (string)$category?->getName(),
                    '/category/search?id=' . (int)$category?->getId() . '&q=' . $data['q'],
                );
            }
        })();

        return new ProductSearchSuggestionArray($productCategoryGenerator);
    }
}
