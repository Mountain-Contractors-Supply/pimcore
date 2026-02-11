<?php

declare(strict_types=1);

namespace App\Model\Product;

use App\EventListener\PreAddUpdateAwareInterface;
use App\Model\AbstractModel;
use McSupply\EcommerceBundle\Dto\Product\LineInterface;
use McSupply\EcommerceBundle\Dto\Product\ProductInterface;
use Pimcore\Model\DataObject\Data\QuantityValue;
use Pimcore\Model\DataObject\Line;
use Pimcore\Model\DataObject\ProductCategory;
use Pimcore\Model\DataObject\QuantityValue\Unit;
use Pimcore\Model\Element\ElementInterface;

/**
 * @extends AbstractModel
 * @implements ProductInterface, PreAddUpdateAwareInterface
 */
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
     * @return QuantityValue|null
     */
    public abstract function getWidthRef(): ?QuantityValue;

    /**
     * @param QuantityValue|null $widthRef
     * @return $this
     */
    public abstract function setWidthRef(?QuantityValue $widthRef): static;

    /**
     * @return QuantityValue|null
     */
    public abstract function getHeightRef(): ?QuantityValue;

    /**
     * @param QuantityValue|null $heightRef
     * @return $this
     */
    public abstract function setHeightRef(?QuantityValue $heightRef): static;

    /**
     * @return QuantityValue|null
     */
    public abstract function getDepthRef(): ?QuantityValue;

    /**
     * @param QuantityValue|null $depthRef
     * @return $this
     */
    public abstract function setDepthRef(?QuantityValue $depthRef): static;

    /**
     * @return QuantityValue|null
     */
    public abstract function getWeightRef(): ?QuantityValue;

    /**
     * @param QuantityValue|null $weightRef
     * @return $this
     */
    public abstract function setWeightRef(?QuantityValue $weightRef): static;

    /**
     * @inheritDoc
     */
    #[\Override]
    public function getProductId(): ?string
    {
        return $this->getKey();
    }

    /**
     * @inheritDoc
     */
    #[\Override]
    public function setProductId(?string $productId): static
    {
        $this->setKey((string) $productId);

        return $this;
    }

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
     * @inheritDoc
     */
    #[\Override]
    public function getWidth(): ?string
    {
        return $this->formatNumericValue($this->getWidthRef());
    }

    /**
     * @inheritDoc
     */
    #[\Override]
    public function setWidth(?string $width): static
    {
        $values = explode(' ', $width);
        $this->setWidthRef(new QuantityValue($values[0], $values[1]));

        return $this;
    }

    /**
     * @inheritDoc
     */
    #[\Override]
    public function getHeight(): ?string
    {
        return $this->formatNumericValue($this->getHeightRef());
    }

    /**
     * @inheritDoc
     */
    #[\Override]
    public function setHeight(?string $height): static
    {
        $values = explode(' ', $height);
        $this->setHeightRef(new QuantityValue($values[0], $values[1]));

        return $this;
    }

    /**
     * @inheritDoc
     */
    #[\Override]
    public function getDepth(): ?string
    {
        return $this->formatNumericValue($this->getDepthRef());
    }

    /**
     * @inheritDoc
     */
    #[\Override]
    public function setDepth(?string $depth): static
    {
        $values = explode(' ', $depth);
        $this->setDepthRef(new QuantityValue($values[0], $values[1]));

        return $this;
    }

    /**
     * @inheritDoc
     */
    #[\Override]
    public function getWeight(): ?string
    {
        return $this->formatNumericValue($this->getWeightRef());
    }

    /**
     * @inheritDoc
     */
    #[\Override]
    public function setWeight(?string $weight): static
    {
        $values = explode(' ', $weight);
        $this->setWeightRef(new QuantityValue($values[0], $values[1]));

        return $this;
    }

    /**
     * @param QuantityValue|null $value
     * @return string|null
     */
    private function formatNumericValue(?QuantityValue $value): ?string
    {
        if ($value === null) {
            return null;
        }

        return sprintf('%s %s', $value->getValue(), $value->getUnit()->getAbbreviation());
    }

    /**
     * @return void
     */
    private function formatUpc(): void
    {
        if (empty($this->getUpc())) {
            return;
        }

        $upc = (string) preg_replace('/[^0-9]/', '', $this->getUpc());

        if (strlen($upc) == 11) {
            $oddTotal = 0;
            $evenTotal = 0;

            for ($i = 0; $i < 11; $i++) {
                if ((($i + 1) % 2) == 0) {
                    $evenTotal += (int) ($upc[$i] ?? 0);
                } else {
                    $oddTotal += (int) ($upc[$i] ?? 0);
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
