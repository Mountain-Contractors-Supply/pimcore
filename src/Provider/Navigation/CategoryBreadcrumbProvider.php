<?php

declare(strict_types=1);

namespace App\Provider\Navigation;

use McSupply\EcommerceBundle\Attribute\DataProvider;
use McSupply\EcommerceBundle\Dto\Navigation\Breadcrumb;
use McSupply\EcommerceBundle\Dto\Navigation\Link;
use McSupply\EcommerceBundle\Dto\Product\ProductCategoryInterface;
use McSupply\EcommerceBundle\LinkGenerator\ProductCategoryLinkGenerator;
use McSupply\EcommerceBundle\Provider\DataProviderInterface;
use McSupply\EcommerceBundle\Provider\ReadOperationInterface;
use McSupply\EcommerceBundle\Provider\DataResolverAwareInterface;
use McSupply\EcommerceBundle\Provider\DataResolverAwareTrait;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * @implements DataProviderInterface<Breadcrumb>
 * @implements ReadOperationInterface<Breadcrumb>
 */
#[DataProvider(Breadcrumb::class, 20)]
final class CategoryBreadcrumbProvider implements DataProviderInterface, ReadOperationInterface, DataResolverAwareInterface
{
    use DataResolverAwareTrait;

    public function __construct(
        private readonly RequestStack $requestStack,
        private readonly ProductCategoryLinkGenerator $productCategoryLinkGenerator,
    ) {}

    #[\Override]
    public function supports(string $className, mixed $data = null): bool
    {
        return $this->requestStack->getMainRequest()?->attributes->get('_route') === 'category_listing';
    }

    #[\Override]
    public function get(string $className, mixed $data = null): Breadcrumb
    {
        $breadcrumbs = new Breadcrumb();
        $category = $this->dataResolver->get(ProductCategoryInterface::class, [
            'id' => $this->requestStack->getMainRequest()?->attributes->get('category'),
        ]);

        $breadcrumbs->add(new Link((string)$category->getName()));
        $parent = $category->getParentCategory();

        while ($parent instanceof ProductCategoryInterface) {
            $breadcrumbs->add(
                new Link(
                    (string)$parent->getName(),
                    $this->productCategoryLinkGenerator->generate($parent)
                )
            );

            $parent = $parent->getParentCategory();
        }

        return $breadcrumbs;
    }
}
