<?php

namespace App\Cart;

use Pimcore\Bundle\EcommerceFrameworkBundle\CartManager\Cart as BaseCart;

class Cart extends BaseCart implements CartInterface
{
    use CartTrait;
}
