<?php

declare(strict_types=1);

namespace App\LinkGenerator;

use McSupply\EcommerceBundle\Dto\Product\ProductCategoryInterface;
use McSupply\EcommerceBundle\Utility\StringUtil;
use Pimcore\Model\DataObject\ClassDefinition\LinkGeneratorInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

final readonly class ProductCategoryLinkGenerator implements LinkGeneratorInterface
{
    public function __construct(
        private UrlGeneratorInterface $urlGenerator,
    ) {}

    /**
     * @inheritDoc
     *
     * @param array<string, mixed> $params
     */
    #[\Override]
    public function generate(object $object, array $params = []): string
    {
        if (!$object instanceof ProductCategoryInterface) {
            return '';
        }

        try {
            return $this->urlGenerator->generate('category_listing', [
                'id' => (int)$object->getId(),
                'slug' => StringUtil::toUrl((string)$object->getName()),
                'page' => $params['page'] ?? 1,
                'limit' => $params['limit'] ?? 10,
            ]);
        } catch (\Exception) {
            return '';
        }
    }
}
