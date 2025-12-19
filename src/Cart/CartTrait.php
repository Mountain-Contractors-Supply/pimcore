<?php

namespace App\Cart;

trait CartTrait
{
    protected ?int $shipBranchId = null;
    protected ?string $shipToId = null;

    /**
     * @param int|null $shipBranchId
     * @return void
     */
    public function setShipBranchId(?int $shipBranchId): void
    {
        $this->shipBranchId = $shipBranchId;
    }

    /**
     * @return int|null
     */
    public function getShipBranchId(): ?int
    {
        return $this->shipBranchId;
    }

    /**
     * @param string|null $shipToId
     * @return void
     */
    public function setShipToId(?string $shipToId): void
    {
        $this->shipToId = $shipToId;
    }

    /**
     * @return string|null
     */
    public function getShipToId(): ?string
    {
        return $this->shipToId;
    }
}
