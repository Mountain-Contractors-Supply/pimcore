<?php

declare(strict_types=1);

namespace App\PreviewGenerator;

use App\LinkGenerator\ProductLinkGenerator;
use McSupply\EcommerceBundle\Dto\OnlineStore\OnlineStoreInterface;
use Pimcore\Model\DataObject\Concrete;
use Pimcore\Model\DataObject\ClassDefinition\PreviewGeneratorInterface;
use Pimcore\Model\DataObject\OnlineStore;

final readonly class StoreAwarePreviewGenerator implements PreviewGeneratorInterface
{
    public function __construct(
        private ProductLinkGenerator $linkGenerator
    ) {}

    /**
     * @inheritDoc
     */
    #[\Override]
    public function getPreviewConfig(Concrete $object): array
    {
        $options = [];

        /** @var OnlineStore\Listing $storeListing */
        $storeListing = (new OnlineStore\Listing())->getData();

        /** @var OnlineStoreInterface $store */
        foreach ($storeListing as $store) {
            $options[$store->getName()] = (string) $store->getId();
        }

        $defaultStoreId = !empty($options) ? $options[array_key_first($options)] : null;

        return [
            [
                'name' => 'store_id',
                'label' => 'Select Store',
                'values' => $options,
                'defaultValue' => $defaultStoreId,
            ]
        ];
    }

    /**
     * @param Concrete $object
     * @param array<string, mixed> $params
     * @return string
     */
    #[\Override]
    public function generatePreviewUrl(Concrete $object, array $params): string
    {
        return $this->linkGenerator->generate($object, $params);
    }
}
