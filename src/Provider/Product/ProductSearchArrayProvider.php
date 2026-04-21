<?php

declare(strict_types=1);

namespace App\Provider\Product;

use App\Dto\Product\ProductSearchArray;
use McSupply\EcommerceBundle\Attribute\DataProvider;
use McSupply\EcommerceBundle\Provider\DataProviderInterface;
use McSupply\EcommerceBundle\Provider\ReadOperationInterface;
use Pimcore\Bundle\GenericDataIndexBundle\Exception\QueryLanguage\ParsingException;
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

    /**
     * @throws ParsingException
     */
    public function get(string $className, array $data = []): ProductSearchArray
    {
        $dataObjectSearch = $this->searchProvider->createDataObjectSearch();
        $dataObjectSearch->setPageSize($data['limit']);
        $data['customer_id'] = 1262;

        if (!empty($data['q'])) {
            $words = array_filter(explode(' ', trim((string)$data['q'])));
            $clauses = [];
            foreach ($words as $w) {
                $wEscaped = addcslashes($w, '"');
                $clauses[] = sprintf('(" %1$s " ^6) OR (%1$s* ^4) OR (%1$s~1 ^1)', $wEscaped);
            }
            $queryString = implode(' ', $clauses);

            // Define the two parts of our "OR"
            $nameMatch = sprintf('Query("standard_fields.name.en_US:(%s)")', $queryString);

            // Only add customer logic if a customer ID is provided
            if (!empty($data['customer_id'])) {
                $custId = (int)$data['customer_id'];
                // Nested PQL logic: Match the ID AND the keyword inside the customer_keywords object
                $customerMatch = sprintf(
                    '(custom_fields.customer_keywords.customer_id = %d AND custom_fields.customer_keywords.keywords = "%s")',
                    $custId,
                    $wEscaped // Using the term directly for the customer keyword check
                );

                // Combine with OR
                $combinedFilter = sprintf('(%s) OR (%s)', $nameMatch, $customerMatch);
                $dataObjectSearch->addModifier(new PqlFilter($combinedFilter));
            } else {
                // Default behavior if no customer context
                $dataObjectSearch->addModifier(new PqlFilter($nameMatch));
            }
        }

        if (!empty($data['id'])) {
            $dataObjectSearch->addModifier(new PqlFilter("custom_fields.category_ids = {$data['id']}"));
        }

        $searchResult = $this->dataObjectSearchService->search($dataObjectSearch);

        return new ProductSearchArray($searchResult->getItems());
    }
}
