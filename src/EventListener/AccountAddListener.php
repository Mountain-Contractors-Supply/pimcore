<?php

namespace App\EventListener;
//
//use McSupply\EcommerceBundle\Api\Integration\ApiService\AccountGetInterface;
//use McSupply\EcommerceBundle\Api\Integration\ApiService\AddressGetInterface;
//use McSupply\EcommerceBundle\Api\Kourier\ApiService\AccountInquiry;
//use McSupply\EcommerceBundle\Api\OpenStreetMap\ApiService\GeoLocationInquiry;
//use McSupply\EcommerceBundle\Dto\Address\GeoLocationInterface;
//use McSupply\EcommerceBundle\Dto\Company\AccountInterface;
//use Pimcore\Event\DataObjectEvents;
//use Pimcore\Event\Model\DataObjectEvent;
//use Symfony\Component\DependencyInjection\Attribute\Autowire;
//use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
//
//#[AsEventListener(event: DataObjectEvents::PRE_ADD, method: 'onPreAdd', priority: -150)]
//#[AsEventListener(event: DataObjectEvents::PRE_UPDATE, method: 'onPreAdd', priority: -150)]
final readonly class AccountAddListener
{
//    private const string ACCOUNT_ROOT_NAME = 'accountRoot';
//
//    /**
//     * @param AccountGetInterface $customerGet
//     * @param AddressGetInterface $geoLocationInquiry
//     */
//    public function __construct(
//        #[Autowire(service: AccountInquiry::class)]
//        private AccountGetInterface $customerGet,
//
//        #[Autowire(service: GeoLocationInquiry::class)]
//        private AddressGetInterface $geoLocationInquiry,
//    )
//    {
//    }
//
//    /**
//     * @param DataObjectEvent $e
//     * @return void
//     */
//    public function onPreAdd(DataObjectEvent $e): void
//    {
//        return;
//
//        $object = $e->getObject();
//
//        if ($object instanceof AccountInterface) {
//            $address = $object->getAddress();
//
//            if ($address === null) {
//                return;
//            }
//
//            if (empty($address->getLine1()) ||
//                empty($address->getCity()) ||
//                empty($address->getState()) ||
//                empty($address->getZip()) ||
//                empty($address->getCountry())
//            ) {
//                $accounts = $this->customerGet->get($object, filters: ['accountId' => $object->getAccountId()]);
//
//                print_r($accounts);
//                die('Test');
//            }
//
//            if ($address instanceof GeoLocationInterface &&
//                (empty($address->getLatitude()) || empty($address->getLongitude()))
//            ) {
//                $this->geoLocationInquiry->get($address);
//            }
//        }
//    }
}
