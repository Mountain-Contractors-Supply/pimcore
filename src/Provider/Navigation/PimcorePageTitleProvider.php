<?php

declare(strict_types=1);

namespace App\Provider\Navigation;

use McSupply\EcommerceBundle\Attribute\DataProvider;
use McSupply\EcommerceBundle\Dto\Navigation\PageTitle;
use McSupply\EcommerceBundle\Provider\DataProviderInterface;
use McSupply\EcommerceBundle\Provider\ReadOperationInterface;
use Pimcore\Model\Document;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * @implements DataProviderInterface<PageTitle>
 * @implements ReadOperationInterface<PageTitle>
 */
#[DataProvider(PageTitle::class, 20)]
final readonly class PimcorePageTitleProvider implements DataProviderInterface, ReadOperationInterface
{
    public function __construct(
        private RequestStack $requestStack,
    ) {}

    #[\Override]
    public function supports(string $className, array $data = []): bool
    {
        return $this->getCurrentDocument() !== null;
    }

    #[\Override]
    public function get(string $className, array $data = []): PageTitle
    {
        $document = $this->getCurrentDocument();
        $title = $document !== null && method_exists($document, 'getTitle')
            ? $document->getTitle()
            : 'Untitled';

        return new PageTitle($title);
    }

    private function getCurrentDocument(): ?Document
    {
        return $this->requestStack->getCurrentRequest()?->attributes->get('contentDocument');
    }
}
