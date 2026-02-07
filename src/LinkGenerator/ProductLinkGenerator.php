<?php

declare(strict_types=1);

namespace App\LinkGenerator;

use App\Website\Tool\Text;
use McSupply\EcommerceBundle\Dto\Product\ProductInterface;
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
                'slug' => Text::toUrl((string)$object->getName()),
            ]);
        } catch (\Exception) {
            return '';
        }
    }
}
