<?php

declare(strict_types=1);

namespace App\Provider;

use InvalidArgumentException;
use McSupply\EcommerceBundle\Api\Integration\ApiService\OrderPostInterface;
use McSupply\EcommerceBundle\Api\WebIntegration\ApiService\SalesOrder;
use McSupply\EcommerceBundle\Dto\Company\AccountInterface;
use McSupply\EcommerceBundle\Dto\Company\BranchInterface;
use McSupply\EcommerceBundle\Dto\Order\Cart;
use McSupply\EcommerceBundle\Dto\Order\CartInterface;
use McSupply\EcommerceBundle\Dto\Order\ItemCollectionInterface;
use McSupply\EcommerceBundle\Dto\Order\Order;
use McSupply\EcommerceBundle\Dto\Order\OrderInterface;
use McSupply\EcommerceBundle\Dto\Product\ProductInterface;
use McSupply\EcommerceBundle\Provider\AccountProviderInterface;
use McSupply\EcommerceBundle\Provider\BranchProviderInterface;
use McSupply\EcommerceBundle\Provider\CartProviderInterface;
use McSupply\EcommerceBundle\Provider\OnlineStoreProviderInterface;
use App\Cart\CartInterface as PimcoreCartInterface;
use Pimcore\Bundle\EcommerceFrameworkBundle\Factory;
use Pimcore\Bundle\EcommerceFrameworkBundle\Model\CheckoutableInterface;
use Pimcore\Model\DataObject\Account;
use Pimcore\Model\DataObject\Branch;
use Pimcore\Model\DataObject\Product;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

final readonly class CartProvider implements CartProviderInterface
{
//    public function __construct(
//        private Factory                      $ecommerceFactory,
//        private AccountProviderInterface     $accountProvider,
//        private BranchProviderInterface      $branchProvider,
//        private OnlineStoreProviderInterface $onlineStoreProvider,
//        private Security                     $security,
//
//        #[Autowire(service: SalesOrder::class)]
//        private OrderPostInterface           $orderPost,
//    )
//    {
//    }
//
//    #[\Override]
//    public function addItem(string $productId, string $uom, int $quantity, ?string $comment = null): CartInterface
//    {
//        return $this->adjustItemQuantity($productId, $uom, $quantity, $comment);
//    }
//
//    #[\Override]
//    public function removeItem(string $productId, string $uom): CartInterface
//    {
//        $cart = $this->getCurrentCart();
//        $cart->removeItem($productId . '_' . $uom);
//        $cart->save();
//
//        return $this->convertCart($cart);
//    }
//
//    #[\Override]
//    public function getCart(): CartInterface
//    {
//        $order = new Order();
//        /** @var OrderInterface $order */
//        $order = $this->convertCart(cart: $order);
//        $this->orderPost->post($order, filters: [
//            'accountId' => $order->getShipTo()?->getAccountId(),
//        ]);
//
//        return $order;
//    }
//
//    #[\Override]
//    public function getCartSummary(): CartInterface
//    {
//        return $this->convertCart(cart: new Order());
//    }
//
//    private function convertCart(?PimcoreCartInterface $currentCart = null, ?CartInterface $cart = null): CartInterface
//    {
//        $currentCart ??= $this->getCurrentCart();
//        $cart ??= new Cart();
//        $shipTo = $currentCart->getShipToId();
//        $shipBranch = $currentCart->getShipBranchId();
//
//        if ($shipTo !== null) {
//            /** @var AccountInterface $account */
//            $account = Account::getByAccountId($shipTo, 1);
//            $cart->setShipTo($account);
//            $cart->setBillTo($account);
//        }
//
//        if ($shipBranch !== null) {
//            $cart->setShipBranch(Branch::getById((int)$currentCart->getShipBranchId()));
//            $cart->setPriceBranch($cart->getShipBranch());
//        }
//
//        foreach ($currentCart->getItems() as $item) {
//            $itemKey = explode('_', $item->getItemKey());
//
//            /** @var ProductInterface $product */
//            $product = $item->getProduct();
//            $cart->addItem($product, $itemKey[1], $item->getCount(), $item->getComment());
//        }
//
//        return $cart;
//    }
//
//    private function getCurrentCart(): PimcoreCartInterface
//    {
//        /** @var PimcoreCartInterface $cart */
//        $cart = $this->ecommerceFactory
//            ->getInstance()
//            ->getCartManager()
//            ->getOrCreateCartByName('Test');
//
//        return $cart;
//    }
//
//    #[\Override]
//    public function clearCart(): CartInterface
//    {
//        $cart = $this->getCurrentCart();
//        $cart->clear();
//        $cart->save();
//
//        return $this->convertCart($cart);
//    }
//
//    #[\Override]
//    public function setShipTo(string $accountId): CartInterface
//    {
//        if (!$this->accountProvider->isValidShipTo($accountId)) {
//            throw new InvalidArgumentException('Invalid account ID: ' . $accountId);
//        }
//
//        $cart = $this->getCurrentCart();
//        $cart->setShipToId($accountId);
//        $cart->save();
//
//        return $this->convertCart($cart);
//    }
//
//    #[\Override]
//    public function setShipBranch(int $branchId): BranchInterface
//    {
//        if (!$this->branchProvider->isValidShipBranch($branchId)) {
//            throw new InvalidArgumentException('Invalid branchId: ' . $branchId);
//        }
//
//        $cart = $this->getCurrentCart();
//        $cart->setShipBranchId($branchId);
//        $cart->save();
//
//        return $this->getShipBranch();
//    }
//
//    /**
//     * @inheritDoc
//     */
//    #[\Override]
//    public function updateItem(string $productId, string $uom, int $quantity, ?string $comment = null): CartInterface
//    {
//        return $this->adjustItemQuantity($productId, $uom, $quantity, $comment, true);
//    }
//
//    private function adjustItemQuantity(
//        string $productId,
//        string $uom,
//        int $quantity,
//        ?string $comment = null,
//        bool $replace = false
//    ): CartInterface
//    {
//        if (!$this->canAddCart()) {
//            throw new InvalidArgumentException('Cannot add to cart because it is not available.');
//        }
//
//        if ($quantity <= 0) {
//            $quantity = 1;
//        }
//
//        $cart = $this->getCurrentCart();
//        $product = Product::getByProductId($productId, 1);
//
//        if ($product instanceof CheckoutableInterface) {
//            $itemKey = $productId . '_' . $uom;
//            $cart->addItem($product, $quantity, $itemKey, $replace, comment: $comment);
//            $cart->save();
//            //$trackingManager = $this->ecommerceFactory->getTrackingManager();
//            //$trackingManager->trackCartProductActionAdd($cart, $product);
//        }
//
//        return $this->convertCart($cart);
//    }
//
//    /**
//     * @inheritDoc
//     */
//    #[\Override]
//    public function updateItems(ItemCollectionInterface $itemCollection): CartInterface
//    {
//        foreach ($itemCollection->getItems() as $item) {
//            $product = $item->getProduct();
//            $quantity = $item->getQuantityOrdered();
//            $productId = $product->getProductId();
//
//            if ($productId !== null) {
//                $this->updateItem(
//                    $productId,
//                    (string)$quantity->getUom(),
//                    $quantity->getQuantity(),
//                    $item->getComment()
//                );
//            }
//        }
//
//        return $this->convertCart();
//    }
//
//    /**
//     * @inheritDoc
//     */
//    #[\Override]
//    public function addItems(ItemCollectionInterface $itemCollection): CartInterface
//    {
//        foreach ($itemCollection->getItems() as $item) {
//            $product = $item->getProduct();
//            $quantity = $item->getQuantityOrdered();
//            $productId = $product->getProductId();
//
//            if ($productId !== null) {
//                $this->addItem(
//                    $productId,
//                    (string)$quantity->getUom(),
//                    $quantity->getQuantity(),
//                    $item->getComment()
//                );
//            }
//        }
//
//        return $this->convertCart();
//    }
//
//    /**
//     * @inheritDoc
//     */
//    #[\Override]
//    public function removeItems(ItemCollectionInterface $itemCollection): CartInterface
//    {
//        foreach ($itemCollection->getItems() as $item) {
//            $product = $item->getProduct();
//            $quantity = $item->getQuantityOrdered();
//            $productId = $product->getProductId();
//
//            if ($productId !== null) {
//                $this->removeItem($productId, (string)$quantity->getUom());
//            }
//        }
//
//        return $this->convertCart();
//    }
//
//    /**
//     * @inheritDoc
//     */
//    #[\Override]
//    public function canAddCart(): bool
//    {
//        return !$this->onlineStoreProvider->getOnlineStore()?->getRequireLogin()
//            || $this->security->isGranted('ROLE_USER');
//    }
//
//    /**
//     * @inheritDoc
//     */
//    #[\Override]
//    public function getShipBranch(): BranchInterface
//    {
//        $branch = Branch::getById($this->getCurrentCart()->getShipBranchId());
//
//        if ($branch === null) {
//            $branch = $this->branchProvider->getValidBranches()[0];
//        }
//
//        return $branch;
//    }
    public function addItem(string $productId, string $uom, int $quantity, ?string $comment = null): CartInterface
    {
        // TODO: Implement addItem() method.
    }

    public function removeItem(string $productId, string $uom): CartInterface
    {
        // TODO: Implement removeItem() method.
    }

    public function getCart(): CartInterface
    {
        // TODO: Implement getCart() method.
    }

    public function getCartSummary(): CartInterface
    {
        // TODO: Implement getCartSummary() method.
    }

    public function clearCart(): CartInterface
    {
        // TODO: Implement clearCart() method.
    }

    public function setShipTo(string $accountId): CartInterface
    {
        // TODO: Implement setShipTo() method.
    }

    public function getShipBranch(): BranchInterface
    {
        // TODO: Implement getShipBranch() method.
    }

    public function setShipBranch(int $branchId): BranchInterface
    {
        // TODO: Implement setShipBranch() method.
    }

    public function updateItem(string $productId, string $uom, int $quantity, ?string $comment = null): CartInterface
    {
        // TODO: Implement updateItem() method.
    }

    public function addItems(ItemCollectionInterface $itemCollection): CartInterface
    {
        // TODO: Implement addItems() method.
    }

    public function updateItems(ItemCollectionInterface $itemCollection): CartInterface
    {
        // TODO: Implement updateItems() method.
    }

    public function removeItems(ItemCollectionInterface $itemCollection): CartInterface
    {
        // TODO: Implement removeItems() method.
    }

    public function canAddCart(): bool
    {
        // TODO: Implement canAddCart() method.
    }
}
