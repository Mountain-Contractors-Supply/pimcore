<?php

declare(strict_types=1);

namespace App\Model\Product;

use App\EventListener\PreAddUpdateAwareInterface;
use App\Model\AbstractModel;
use McSupply\EcommerceBundle\Dto\Product\LineInterface;
use McSupply\EcommerceBundle\Dto\Product\ProductInterface;
use Pimcore\Model\DataObject\Line;
use Pimcore\Model\DataObject\ProductCategory;
use Pimcore\Model\Element\ElementInterface;

abstract class AbstractProduct extends AbstractModel implements ProductInterface, PreAddUpdateAwareInterface
{
    /**
     * @return ProductCategory[]
     */
    public abstract function getCategoriesRef(): array;

    /**
     * @param ProductCategory[] $categoriesRef
     *
     * @return $this
     */
    public abstract function setCategoriesRef(?array $categoriesRef): static;

    /**
     * @inheritDoc
     */
    #[\Override]
    public function getLine(): LineInterface
    {
        $parent = $this->getParent();

        if (!$parent instanceof LineInterface) {
            $parent = new Line();
            $this->setLine($parent);
        }

        return $parent;
    }

    /**
     * @inheritDoc
     */
    #[\Override]
    public function setLine(?LineInterface $line): static
    {
        if ($line instanceof ElementInterface) {
            $this->setParent($line);
        }

        return $this;
    }

    /**
     * @inheritDoc
     */
    #[\Override]
    public function getBrandName(): string
    {
        $line = $this->getLine();

        return $line->getBrand()?->getName() ?? $line->getLineId() ?? '';
    }

    /**
     * @return ProductCategory[]
     */
    #[\Override]
    public function getCategories(): array
    {
        return $this->getCategoriesRef();
    }

    /**
     * @inheritDoc
     */
    #[\Override]
    public function setCategories(?array $categories): static
    {
        /** @var ProductCategory[] $categories */
        $this->setCategoriesRef($categories);

        return $this;
    }

    /**
     * @inheritDoc
     */
    #[\Override]
    public function onPreAdd(): void
    {
        $this->onPreUpdate();
    }

    /**
     * @inheritDoc
     */
    #[\Override]
    public function onPreUpdate(): void
    {
        $this->setProductId($this->getKey());
        $this->formatUpc();
    }

    /**
     * @return void
     */
    private function formatUpc(): void
    {
        if (empty($this->getUpc())) {
            return;
        }

        $upc = (string)preg_replace('/[^0-9]/', '', $this->getUpc());

        if (strlen($upc) == 11) {
            $oddTotal = 0;
            $evenTotal = 0;

            for ($i = 0; $i < 11; $i++) {
                if ((($i + 1) % 2) == 0) {
                    $evenTotal += (int)($upc[$i] ?? 0);
                } else {
                    $oddTotal += (int)($upc[$i] ?? 0);
                }
            }

            $sum = (3 * $oddTotal) + $evenTotal;
            $checkDigit = $sum % 10;
            $formattedUPC = $upc . (($checkDigit > 0) ? 10 - $checkDigit : $checkDigit);
        } elseif (strlen($upc) != 12) {
            $formattedUPC = '';
        }

        if (isset($formattedUPC)) {
            $this->setUpc($formattedUPC);
        }
    }
}
