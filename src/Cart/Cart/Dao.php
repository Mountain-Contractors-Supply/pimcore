<?php

namespace App\Cart\Cart;

use Pimcore\Bundle\EcommerceFrameworkBundle\CartManager\Cart\Dao as CartDao;

class Dao extends CartDao
{
    /** @var string[] */
    protected array $fieldsToSave = ['name', 'userid', 'creationDateTimestamp', 'modificationDateTimestamp', 'shipToId', 'shipBranchId'];
}
