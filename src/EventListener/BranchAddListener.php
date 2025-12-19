<?php

declare(strict_types=1);

namespace App\EventListener;

use McSupply\EcommerceBundle\Api\Integration\ApiService\AddressGetInterface;
use McSupply\EcommerceBundle\Api\Integration\ApiService\BranchGetInterface;
use McSupply\EcommerceBundle\Api\Kourier\ApiService\BranchInquiry;
use McSupply\EcommerceBundle\Api\OpenStreetMap\ApiService\GeoLocationInquiry;
use McSupply\EcommerceBundle\Dto\Address\GeoLocationInterface;
use McSupply\EcommerceBundle\Dto\Company\BranchInterface;
use Pimcore\Event\DataObjectEvents;
use Pimcore\Event\Model\DataObjectEvent;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;

#[AsEventListener(event: DataObjectEvents::PRE_ADD, method: 'onPreAdd', priority: -150)]
#[AsEventListener(event: DataObjectEvents::PRE_UPDATE, method: 'onPreAdd', priority: -150)]

final readonly class BranchAddListener
{
    /**
     * @param BranchGetInterface $branchInquiry
     * @param AddressGetInterface $geoLocationInquiry
     */
    public function __construct(
        #[Autowire(service: BranchInquiry::class)]
        private BranchGetInterface $branchInquiry,

        #[Autowire(service: GeoLocationInquiry::class)]
        private AddressGetInterface $geoLocationInquiry,
    ) {
    }

    /**
     * @param DataObjectEvent $e
     * @return void
     */
    public function onPreAdd(DataObjectEvent $e): void
    {
        $object = $e->getObject();

        if ($object instanceof BranchInterface) {
            $address = $object->getAddress();

            if ($address === null) {
                return;
            }

            if (empty($address->getLine1()) ||
                empty($address->getCity()) ||
                empty($address->getState()) ||
                empty($address->getZip()) ||
                empty($address->getCountry())
            ) {
                $this->branchInquiry->get($object, filters: ['branchId' => $object->getBranchId()]);
            }

            if ($address instanceof GeoLocationInterface &&
                (empty($address->getLatitude()) || empty($address->getLongitude()))
            ) {
                $this->geoLocationInquiry->get($address);
            }
        }
    }
}
