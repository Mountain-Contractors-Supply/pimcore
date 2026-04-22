<?php

declare(strict_types=1);

namespace App\Provider\Product;

use App\Dto\Product\ProductSearchArray;
use McSupply\EcommerceBundle\Attribute\DataProvider;
use McSupply\EcommerceBundle\Dto\Order\Cart;
use McSupply\EcommerceBundle\Provider\DataProviderInterface;
use McSupply\EcommerceBundle\Provider\DataResolverAwareInterface;
use McSupply\EcommerceBundle\Provider\DataResolverAwareTrait;
use McSupply\EcommerceBundle\Provider\DataResolverInterface;
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
final class ProductSearchArrayProvider implements DataProviderInterface, ReadOperationInterface, DataResolverAwareInterface
{
    use DataResolverAwareTrait;

    public function __construct(
        private readonly SearchProviderInterface $searchProvider,
        private readonly DataObjectSearchServiceInterface $dataObjectSearchService,
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
        $cart = $this->dataResolver->get(Cart::class);
        $dataObjectSearch = $this->searchProvider->createDataObjectSearch();
        $dataObjectSearch->setPageSize($data['limit']);
        $accountId = (int)$cart->getShipTo()?->getAccountId();

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
            if ($accountId) {
                $customerMatch = sprintf(
                    '(custom_fields.customer_keywords.customer_id = %d AND custom_fields.customer_keywords.keywords = "%s")',
                    $accountId,
                    addcslashes(trim((string)$data['q']), '"')
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
