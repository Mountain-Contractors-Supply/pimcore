<?php

declare(strict_types=1);

namespace App\EventListener;

use App\Model\Product\ProductTypeStyle;
use McSupply\EcommerceBundle\Dto\Product\ProductTypeInterface;
use Pimcore\Bundle\AdminBundle\Event\AdminEvents;
use Pimcore\Bundle\AdminBundle\Event\ElementAdminStyleEvent;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;

#[AsEventListener(event: AdminEvents::RESOLVE_ELEMENT_ADMIN_STYLE, method: 'onResolveElementAdminStyle')]
class AdminStyleListener
{
    /**
     * @param ElementAdminStyleEvent $event
     * @return void
     */
    public function onResolveElementAdminStyle(ElementAdminStyleEvent $event): void
    {
        $element = $event->getElement();

        if ($element instanceof ProductTypeInterface) {
            $event->setAdminStyle(new ProductTypeStyle($element));
        }
    }
}

