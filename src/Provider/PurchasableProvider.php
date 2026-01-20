<?php

declare(strict_types=1);

namespace App\Provider;

use InvalidArgumentException;
use McSupply\EcommerceBundle\Dto\Company\BranchInterface;
use McSupply\EcommerceBundle\Dto\Order\Cart;
use McSupply\EcommerceBundle\Dto\Order\CartInterface;
use McSupply\EcommerceBundle\Dto\Order\ItemCollectionInterface;
use McSupply\EcommerceBundle\Dto\Order\PurchasableInterface;
use McSupply\EcommerceBundle\Dto\Order\PurchasableTypeEnum;
use McSupply\EcommerceBundle\Provider\AccountProviderInterface;
use McSupply\EcommerceBundle\Provider\BranchProviderInterface;
use McSupply\EcommerceBundle\Provider\PurchasableProviderInterface;
use McSupply\EcommerceBundle\Provider\OnlineStoreProviderInterface;
use McSupply\EcommerceBundle\Resolver\PurchasableContext;
use Pimcore\Model\DataObject\Account;
use Pimcore\Model\DataObject\Branch;
use Pimcore\Model\DataObject\Product;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Serializer\Exception\ExceptionInterface;

final readonly class PurchasableProvider implements PurchasableProviderInterface
{
    public function __construct(
        private PurchasableContext $purchasableContext,
        private AccountProviderInterface     $accountProvider,
        private BranchProviderInterface      $branchProvider,
        private OnlineStoreProviderInterface $onlineStoreProvider,
        private Security                     $security,
    )
    {
    }

    /**
     * @inheritDoc
     * @throws ExceptionInterface
     */
    #[\Override]
    public function addItem(string $productId, string $uom, int $quantity, ?string $comment = null): PurchasableInterface
    {
        return $this->adjustItemQuantity($productId, $uom, $quantity, $comment);
    }

    /**
     * @inheritDoc
     * @throws ExceptionInterface
     */
    #[\Override]
    public function removeItem(string $productId, string $uom): PurchasableInterface
    {
        $cart = $this->getCurrentCart();
        $cart->removeItem($productId, $uom);
        $this->purchasableContext->save(PurchasableTypeEnum::CART, $cart);

        return $cart;
    }

    /**
     * @inheritDoc
     * @throws ExceptionInterface
     */
    #[\Override]
    public function getPurchasable(string $className = Cart::class): PurchasableInterface
    {
        return $this->getCurrentCart($className);
    }

    /**
     * @template T of PurchasableInterface
     * @param class-string<T> $className
     * @return T
     * @throws ExceptionInterface
     */
    private function getCurrentCart(string $className = Cart::class): PurchasableInterface
    {
        return $this->purchasableContext->resolve($className);
    }

    /**
     * @inheritDoc
     * @throws ExceptionInterface
     */
    #[\Override]
    public function clearCart(): PurchasableInterface
    {
        return $this->getCurrentCart();
    }

    /**
     * @inheritDoc
     * @throws ExceptionInterface
     */
    #[\Override]
    public function setShipTo(string $accountId): PurchasableInterface
    {
        if (!$this->accountProvider->isValidShipTo($accountId)) {
            throw new InvalidArgumentException('Invalid account ID: ' . $accountId);
        }


        $cart = $this->getCurrentCart();
        $account = Account::getByAccountId($accountId, 1);
        $cart->setShipTo($account);
        $this->purchasableContext->save(PurchasableTypeEnum::CART, $cart);

        return $cart;
    }

    /**
     * @inheritDoc
     * @throws ExceptionInterface
     */
    #[\Override]
    public function setShipBranch(int $branchId): PurchasableInterface
    {
        if (!$this->branchProvider->isValidShipBranch($branchId)) {
            throw new InvalidArgumentException('Invalid branchId: ' . $branchId);
        }

        /** @var CartInterface $cart */
        $cart = $this->getCurrentCart();
        $branch = Branch::getById($branchId);
        $cart->setShipBranch($branch);
        $this->purchasableContext->save(PurchasableTypeEnum::CART, $cart);

        return $cart;
    }

    /**
     * @inheritDoc
     * @throws ExceptionInterface
     */
    #[\Override]
    public function updateItem(string $productId, string $uom, int $quantity, ?string $comment = null): PurchasableInterface
    {
        return $this->adjustItemQuantity($productId, $uom, $quantity, $comment);
    }

    /**
     * @throws ExceptionInterface
     */
    private function adjustItemQuantity(
        string $productId,
        string $uom,
        int $quantity,
        ?string $comment = null
    ): PurchasableInterface
    {
        if (!$this->canAddCart()) {
            throw new InvalidArgumentException('Cannot add to cart because it is not available.');
        }

        $cart = $this->getCurrentCart();
        $product = Product::getByProductId($productId, 1);

        $cart->addItem($product, $uom, $quantity, $comment);
        $this->purchasableContext->save(PurchasableTypeEnum::CART, $cart);

        return $cart;
    }

    /**
     * @inheritDoc
     * @throws ExceptionInterface
     */
    #[\Override]
    public function updateItems(ItemCollectionInterface $itemCollection): PurchasableInterface
    {
        $cart = $this->getCurrentCart();
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

        return $cart;
    }

    /**
     * @inheritDoc
     * @throws ExceptionInterface
     */
    #[\Override]
    public function addItems(ItemCollectionInterface $itemCollection): PurchasableInterface
    {
        $cart = $this->getCurrentCart();
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

        return $cart;
    }

    /**
     * @inheritDoc
     * @throws ExceptionInterface
     */
    #[\Override]
    public function removeItems(ItemCollectionInterface $itemCollection): PurchasableInterface
    {
        $cart = $this->getCurrentCart();

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

        return $cart;
    }

    /**
     * @inheritDoc
     */
    #[\Override]
    public function canAddCart(): bool
    {
        return !$this->onlineStoreProvider->getOnlineStore()?->getRequireLogin()
            || $this->security->isGranted('ROLE_USER');
    }

    /**
     * @inheritDoc
     * @throws ExceptionInterface
     */
    #[\Override]
    public function getShipBranch(): BranchInterface
    {
        $branch = $this->getCurrentCart()->getShipBranch();

        if ($branch === null) {
            $branch = $this->branchProvider->getValidBranches()[0];
        }

        return Branch::getById($branch->getId());
    }
}
