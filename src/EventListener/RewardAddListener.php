<?php

declare(strict_types=1);

namespace App\EventListener;

use McSupply\EcommerceBundle\Api\OpenStreetMap\ApiService\GeoLocationInquiry;
use McSupply\EcommerceBundle\Dto\Reward\RewardInterface;
use Pimcore\Event\DataObjectEvents;
use Pimcore\Event\Model\DataObjectEvent;
use Psr\Http\Client\ClientExceptionInterface;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\Serializer\Exception\ExceptionInterface;

#[AsEventListener(event: DataObjectEvents::PRE_UPDATE, method: 'onPreAdd', priority: -150)]
final readonly class RewardAddListener
{
    public function __construct(
        private GeoLocationInquiry $geoLocationInquiry
    ) {
    }

    /**
     * @throws ClientExceptionInterface
     * @throws ExceptionInterface
     */
    public function onPreAdd(DataObjectEvent $e): void
    {
        $object = $e->getObject();

        if ($object instanceof RewardInterface) {
            $address = $object->getAddress();

            if ($address !== null) {
                $this->geoLocationInquiry->get($address);
            }
        }
    }
}
