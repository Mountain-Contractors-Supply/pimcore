<?php

declare(strict_types=1);

namespace App\EventListener;

use McSupply\EcommerceBundle\Api\Integration\ApiService\ProductGetInterface;
use McSupply\EcommerceBundle\Api\WebIntegration\ApiService\ProductInquiry;
use Pimcore\Event\DataObjectEvents;
use Pimcore\Event\Model\DataObjectEvent;
use Pimcore\Model\DataObject;
use Pimcore\Model\DataObject\Line;
use Pimcore\Model\DataObject\Product;
use Pimcore\Model\WebsiteSetting;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;

//#[AsEventListener(event: DataObjectEvents::PRE_ADD, method: 'onPreAdd', priority: -150)]
//#[AsEventListener(event: DataObjectEvents::PRE_UPDATE, method: 'onPreAdd', priority: -150)]
final readonly class ProductAddListener
{
//    private const string PRODUCT_ROOT_NAME = 'productRoot';
//
//    /**
//     * @param ProductGetInterface $productInquiry
//     */
//    public function __construct(
//        #[Autowire(service: ProductInquiry::class)]
//        private ProductGetInterface $productInquiry,
//    ) {
//
//    }
//
//    /**
//     * @throws \Exception
//     */
//    public function onPreAdd(DataObjectEvent $e): void
//    {
//        // TODO: Handle better when using DataHub import to not make an API call for each product - return for now
//        return;
//        $object = $e->getObject();
//
//        if ($object instanceof Product && empty($object->getLine()->getLineId())) {
//            $this->productInquiry->get($object, '', ['productId' => $object->getProductId()]);
//
//            /** @var Line $line */
//            $line = $object->getLine();
//            $productRoot = WebsiteSetting::getByName(self::PRODUCT_ROOT_NAME)?->getData();
//            $parent = Line::getByLineId($line->getLineId(), 1);
//
//            if ($parent !== $line) {
//                if ($parent === null) {
//                    $line->setParent(DataObject::getByPath($productRoot));
//                    $line->save();
//                } else {
//                    $object->setParent($parent);
//                }
//            }
//        }
//    }
}
