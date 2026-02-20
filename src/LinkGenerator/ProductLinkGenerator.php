<?php

declare(strict_types=1);

namespace App\LinkGenerator;

use McSupply\EcommerceBundle\Dto\Product\ProductInterface;
use McSupply\EcommerceBundle\Utility\StringUtil;
use Pimcore\Model\DataObject\ClassDefinition\LinkGeneratorInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

final readonly class ProductLinkGenerator implements LinkGeneratorInterface
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
        if (!$object instanceof ProductInterface) {
            return '';
        }

        try {
            return $this->urlGenerator->generate('product_detail', [
                'productId' => (int)$object->getProductId(),
                'slug' => StringUtil::toUrl((string)$object->getName()),
                'uom' => $params['parameters']['uom'] ?? 'ea',
                'store_id' => $params['store_id'] ?? null,
            ]);
        } catch (\Exception $exception) {
            return '';
        }
    }
}
