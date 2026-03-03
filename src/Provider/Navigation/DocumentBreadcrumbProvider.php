<?php

declare(strict_types=1);

namespace App\Provider\Navigation;

use McSupply\EcommerceBundle\Attribute\DataProvider;
use McSupply\EcommerceBundle\Dto\Navigation\Breadcrumb;
use McSupply\EcommerceBundle\Dto\Navigation\Link;
use McSupply\EcommerceBundle\Provider\DataProviderInterface;
use McSupply\EcommerceBundle\Resolver\DefaultDataResolver;
use Pimcore\Model\Document;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * @implements DataProviderInterface<Breadcrumb>
 */
#[DataProvider(Breadcrumb::class, DefaultDataResolver::class, 10)]
final readonly class DocumentBreadcrumbProvider implements DataProviderInterface
{
    public function __construct(
        private RequestStack $requestStack,
    ) {}

    #[\Override]
    public function supports(string $className, mixed $data = null): bool
    {
        return $this->getCurrentDocument() !== null;
    }

    #[\Override]
    public function get(string $className, mixed $data = null): Breadcrumb
    {
        $document = $this->getCurrentDocument();
        $breadcrumbs = new Breadcrumb();
        $breadcrumbs->add(new Link((string)$document->getTitle()));

        return $breadcrumbs;
    }

    #[\Override]
    public function save(mixed $dto, mixed $data = null): void
    {
    }

    /**
     * @return Document|null
     */
    private function getCurrentDocument(): ?Document
    {
        return $this->requestStack->getCurrentRequest()?->attributes->get('contentDocument');
    }
}
