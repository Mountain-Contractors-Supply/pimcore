<?php

declare(strict_types=1);

namespace App\Model\Product;

use App\EventListener\PreAddUpdateAwareInterface;
use App\Model\AbstractModel;
use McSupply\EcommerceBundle\Dto\Navigation\SlugAwareTrait;
use McSupply\EcommerceBundle\Dto\Product\LineInterface;
use McSupply\EcommerceBundle\Dto\Product\ProductInterface;
use Pimcore\Model\DataObject\Data\QuantityValue;
use Pimcore\Model\DataObject\Line;
use Pimcore\Model\DataObject\ProductCategory;
use Pimcore\Model\Element\ElementInterface;

abstract class AbstractProduct extends AbstractModel implements ProductInterface, PreAddUpdateAwareInterface
{
    use SlugAwareTrait;

    private ?string $price = null;

    #[\Override]
    public function getPrice(): ?string
    {
        return $this->price;
    }

    #[\Override]
    public function setPrice(?string $price): static
    {
        $this->price = $price;

        return $this;
    }

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
    public abstract function getWidthRef(): ?QuantityValue;
    public abstract function setWidthRef(?QuantityValue $widthRef): static;
    public abstract function getHeightRef(): ?QuantityValue;
    public abstract function setHeightRef(?QuantityValue $heightRef): static;
    public abstract function getLengthRef(): ?QuantityValue;
    public abstract function setLengthRef(?QuantityValue $lengthRef): static;
    public abstract function getWeightRef(): ?QuantityValue;
    public abstract function setWeightRef(?QuantityValue $weightRef): static;

    #[\Override]
    public function getProductId(): ?string
    {
        return $this->getKey();
    }

    #[\Override]
    public function setProductId(?string $productId): static
    {
        $this->setKey((string) $productId);

        return $this;
    }

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

    #[\Override]
    public function setLine(?LineInterface $line): static
    {
        if ($line instanceof ElementInterface) {
            $this->setParent($line);
        }

        return $this;
    }

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

    #[\Override]
    public function setCategories(?array $categories): static
    {
        /** @var ProductCategory[] $categories */
        $this->setCategoriesRef($categories);

        return $this;
    }

    #[\Override]
    public function onPreAdd(): void
    {
        $this->onPreUpdate();
    }

    #[\Override]
    public function onPreUpdate(): void
    {
        $this->setProductId($this->getKey());
        $this->formatUpc();
    }

    #[\Override]
    public function getWidth(): ?string
    {
        return $this->formatQuantityValue($this->getWidthRef());
    }

    #[\Override]
    public function setWidth(?string $width): static
    {
        $this->setWidthRef($this->prepareQuantityValue($width));

        return $this;
    }

    #[\Override]
    public function getHeight(): ?string
    {
        return $this->formatQuantityValue($this->getHeightRef());
    }

    #[\Override]
    public function setHeight(?string $height): static
    {
        $this->setHeightRef($this->prepareQuantityValue($height));

        return $this;
    }

    #[\Override]
    public function getLength(): ?string
    {
        return $this->formatQuantityValue($this->getLengthRef());
    }

    #[\Override]
    public function setLength(?string $length): static
    {
        $this->setLengthRef($this->prepareQuantityValue($length));

        return $this;
    }

    #[\Override]
    public function getWeight(): ?string
    {
        return $this->formatQuantityValue($this->getWeightRef());
    }

    #[\Override]
    public function setWeight(?string $weight): static
    {
        $this->setWeightRef($this->prepareQuantityValue($weight));

        return $this;
    }

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

    private function formatQuantityValue(?QuantityValue $value): ?string
    {
        if ($value === null) {
            return null;
        }

        return sprintf('%s %s', $value->getValue(), $value->getUnit()?->getAbbreviation());
    }

    private function prepareQuantityValue(?string $quantityValue): ?QuantityValue
    {
        if ($quantityValue === null) {
            return null;
        }

        $values = explode(' ', $quantityValue);

        return new QuantityValue($values[0], $values[1]);
    }
}
