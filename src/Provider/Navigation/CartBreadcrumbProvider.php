<?php

declare(strict_types=1);

namespace App\Provider\Navigation;

use McSupply\EcommerceBundle\Attribute\DataProvider;
use McSupply\EcommerceBundle\Dto\Navigation\Breadcrumb;
use McSupply\EcommerceBundle\Dto\Navigation\Link;
use McSupply\EcommerceBundle\Provider\DataProviderInterface;
use McSupply\EcommerceBundle\Provider\ReadOperationInterface;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * @implements DataProviderInterface<Breadcrumb>
 * @implements ReadOperationInterface<Breadcrumb>
 */
#[DataProvider(Breadcrumb::class, 20)]
final readonly class CartBreadcrumbProvider implements DataProviderInterface, ReadOperationInterface
{
    public function __construct(
        private RequestStack $requestStack,
    ) {}

    #[\Override]
    public function supports(string $className, mixed $data = null): bool
    {
        return $this->requestStack->getMainRequest()?->attributes->get('_route') === 'cart';
    }

    #[\Override]
    public function get(string $className, mixed $data = null): Breadcrumb
    {
        return new Breadcrumb([new Link('Cart')]);
    }
}
