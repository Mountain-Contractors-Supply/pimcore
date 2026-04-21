<?php

declare(strict_types=1);

namespace App\Provider\Product;

use McSupply\EcommerceBundle\Attribute\DataProvider;
use McSupply\EcommerceBundle\Dto\OnlineStore\OnlineStoreInterface;
use McSupply\EcommerceBundle\Dto\Product\ProductCategoryArray;
use McSupply\EcommerceBundle\Provider\DataProviderInterface;
use McSupply\EcommerceBundle\Provider\DataResolverAwareInterface;
use McSupply\EcommerceBundle\Provider\DataResolverAwareTrait;
use McSupply\EcommerceBundle\Provider\ReadOperationInterface;
use Pimcore\Bundle\GenericDataIndexBundle\Model\Search\Modifier\QueryLanguage\PqlFilter;
use Pimcore\Bundle\GenericDataIndexBundle\Service\Search\SearchService\DataObject\DataObjectSearchServiceInterface;
use Pimcore\Bundle\GenericDataIndexBundle\Service\Search\SearchService\SearchProviderInterface;
use Pimcore\Model\DataObject\ProductCategory;

/**
 * @implements DataProviderInterface<ProductCategoryArray>
 * @implements ReadOperationInterface<ProductCategoryArray>
 */
#[DataProvider(ProductCategoryArray::class, 10)]
final class PimcoreProductCategorySearchBarProvider implements DataProviderInterface, ReadOperationInterface, DataResolverAwareInterface
{
    use DataResolverAwareTrait;

    public function __construct(
        private readonly SearchProviderInterface $searchProvider,
        private readonly DataObjectSearchServiceInterface $dataObjectSearchService
    ) {}


    public function supports(string $className, array $data = []): bool
    {
        return true;
    }

    public function get(string $className, array $data = []): ProductCategoryArray
    {
        $categoryId = $this->dataResolver->get(OnlineStoreInterface::class)->getRootProductCategory()?->getId();

        // If we don't have a root category, return empty
        if ($categoryId === null) {
            return new ProductCategoryArray();
        }

        try {
            $pql = "(parentId = $categoryId OR id = $categoryId";

            if (!empty($data['id'])) {
                $pql .= " OR id = {$data['id']}";
            }

            $pql .= ")";
            $dataObjectSearch = $this->searchProvider
                ->createDataObjectSearch()
                ->addModifier(new PqlFilter($pql));
            $searchResult = $this->dataObjectSearchService->search($dataObjectSearch);
            $items = $searchResult->getItems();

            usort($items, function ($a, $b) use ($categoryId) {
                $aCustomFields = $a->getSearchIndexData();
                $bCustomFields = $b->getSearchIndexData();
                $aId = $a->getId();
                $aParentId = $a->getParentId();
                $bId = $b->getId();
                $bParentId = $b->getParentId();
                $aWeight = $aId == $categoryId ? 1 : ($aParentId != $categoryId ? 0 : 2);
                $bWeight = $bId == $categoryId ? 1 : ($bParentId != $categoryId ? 0 : 2);

                if ($aWeight === $bWeight) {
                    return $aCustomFields['standard_fields']['name']['en_US'] <=> $bCustomFields['standard_fields']['name']['en_US'];
                }

                return $aWeight <=> $bWeight;
            });

            $productCategoryGenerator = (function () use ($items): \Generator {
                foreach ($items as $item) {
                    $customFields = $item->getSearchIndexData();

                    yield (new ProductCategory())
                        ->setId($item->getId())
                        ->setName($customFields['standard_fields']['name']['en_US']);
                }
            })();

            return new ProductCategoryArray($productCategoryGenerator);
        } catch (\Exception $ex) {

        }

        return new ProductCategoryArray();
    }
}
