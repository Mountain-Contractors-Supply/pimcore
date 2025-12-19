<?php

namespace App\Cart;

use Pimcore\Bundle\EcommerceFrameworkBundle\CartManager\SessionCart as BaseSessionCart;

class SessionCart extends BaseSessionCart implements CartInterface
{
    use CartTrait;

    public function clearCheckout(): void
    {
        $session = static::getSessionBag();
        $carts = $session->get('carts');
        $data = unserialize($carts[$this->getId()]);
        $data->checkoutData = [];
        $carts[$this->getId()] = serialize($data);
        $session->set('carts', $carts);
    }
}
