<?php

declare(strict_types=1);

namespace App\Model\Address;

use McSupply\EcommerceBundle\Dto\Address\AddressInterface;
use McSupply\EcommerceBundle\Dto\Address\GeoLocationInterface;
use Pimcore\Model\DataObject\Data\GeoCoordinates;
use Pimcore\Model\DataObject\Objectbrick\Data\AbstractData;

abstract class AbstractAddress extends AbstractData implements AddressInterface, GeoLocationInterface
{
    /**
     * @return GeoCoordinates|null
     */
    public abstract function getLocation(): ?GeoCoordinates;

    /**
     * @param GeoCoordinates|null $location
     * @return $this
     */
    public abstract function setLocation(?GeoCoordinates $location): static;

    /**
     * @inheritDoc
     */
    #[\Override]
    public function getCoordinates(): array
    {
        return [
            'latitude' => $this->getLatitude(),
            'longitude' => $this->getLongitude(),
        ];
    }

    /**
     * @inheritDoc
     */
    #[\Override]
    public function getLongitude(): ?float
    {
        return $this->getLocation()?->getLongitude();
    }

    /**
     * @inheritDoc
     */
    #[\Override]
    public function setLongitude(?float $longitude): static
    {
        $this->getOrCreateLocation()->setLongitude($longitude);

        return $this;
    }

    /**
     * @inheritDoc
     */
    #[\Override]
    public function getLatitude(): ?float
    {
        return $this->getLocation()?->getLatitude();
    }

    /**
     * @inheritDoc
     */
    #[\Override]
    public function setLatitude(?float $latitude): static
    {
        $this->getOrCreateLocation()->setLatitude($latitude);

        return $this;
    }

    /**
     * @return GeoCoordinates
     */
    private function getOrCreateLocation(): GeoCoordinates
    {
        $location = $this->getLocation();

        if ($location === null) {
            $location = new GeoCoordinates();
            $this->setLocation($location);
        }

        return $location;
    }
}
