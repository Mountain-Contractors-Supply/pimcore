<?php

namespace App\Cart;

use Pimcore\Bundle\EcommerceFrameworkBundle\CartManager\CartInterface as PimcoreCartInterface;

interface CartInterface extends PimcoreCartInterface
{
    /**
     * @param int|null $shipBranchId
     * @return void
     */
    public function setShipBranchId(?int $shipBranchId): void;

    /**
     * @return int|null
     */
    public function getShipBranchId(): ?int;

    /**
     * @param string|null $shipToId
     * @return void
     */
    public function setShipToId(?string $shipToId): void;

    /**
     * @return string|null
     */
    public function getShipToId(): ?string;

    public function removeItem(string $string);

    public function save();

    public function getItems();

    public function clear();

    public function addItem(\Pimcore\Bundle\EcommerceFrameworkBundle\Model\CheckoutableInterface $product, int $quantity, string $itemKey, bool $replace, ?string $comment);
}
