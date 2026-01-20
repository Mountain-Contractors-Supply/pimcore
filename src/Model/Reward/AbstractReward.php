<?php

declare(strict_types=1);

namespace App\Model\Reward;

use App\EventListener\PreAddUpdateAwareInterface;
use App\Model\AbstractModel;
use App\Model\Traits\SetKeyFromValueTrait;
use Carbon\Carbon;
use Exception;
use McSupply\EcommerceBundle\Dto\Address\AddressInterface;
use McSupply\EcommerceBundle\Dto\Reward\RewardCategoryInterface;
use McSupply\EcommerceBundle\Dto\Reward\RewardInterface;
use Pimcore\Model\DataObject;
use Pimcore\Model\DataObject\Objectbrick;
use Pimcore\Model\DataObject\Reward\AddressBrick;
use Pimcore\Model\DataObject\RewardCategory;
use Pimcore\Model\Element\DuplicateFullPathException;

abstract class AbstractReward extends AbstractModel implements RewardInterface, PreAddUpdateAwareInterface
{
    use SetKeyFromValueTrait;

    /**
     * @return ?AddressBrick
     */
    public abstract function getAddressBrick(): ?Objectbrick;

    public abstract function getStartDate(): ?Carbon;

    public function getAddress(): ?AddressInterface
    {
        return $this->getAddressBrick()?->getAddress();
    }

    /**
     * @return $this
     */
    public function setAddress(?AddressInterface $address): static
    {
        /** @var Objectbrick\Data\Address $address */
        $this->getAddressBrick()?->setAddress($address);

        return $this;
    }

    /**
     * @throws Exception
     */
    public function onPreAdd(): void
    {
        $this->setName($this->getKey());
        $this->onPreUpdate();
    }

    /**
     * @throws Exception
     */
    public function onPostAdd(): void
    {
        $this->onPostUpdate();
    }

    /**
     * @throws Exception
     */
    public function onPreUpdate(): void
    {
        $this->setKeyFromValue((string)$this->getName());
        $this->addRewardToStartDateFolder();
    }

    /**
     * @throws Exception
     */
    public function onPostUpdate(): void
    {
        $this->addRewardToRewardCategory();
    }

    /**
     * @throws DuplicateFullPathException
     */
    private function addRewardToStartDateFolder(): void
    {
        $rewardCategory = $this->getRewardCategory();

        if ($rewardCategory === null) {
            return;
        }

        $folderName = $this->getFolderName();
        $parent = $this->getParent();

        if ($parent instanceof DataObject\Folder && $parent->getKey() === $folderName) {
            return;
        }

        $folder = DataObject::getByPath($rewardCategory->getFullPath() . '/' . $folderName);

        if ($folder === null) {
            $folder = new DataObject\Folder();
            $folder->setKey($folderName);
            $folder->setParent($rewardCategory);
            $folder->setChildrenSortOrder(DataObject\AbstractObject::OBJECT_CHILDREN_SORT_BY_INDEX);
            $folder->save();
        }

        $this->setParent($folder);
    }

    /**
     * @throws Exception
     */
    private function addRewardToRewardCategory(): void
    {
        $rewardCategory = $this->getRewardCategory();
        $rewardCategory?->addReward($this);
    }

    private function getRewardCategory(): ?RewardCategory
    {
        $cat = $this->getClosestParentOfClass(RewardCategory::classId());

        return $cat instanceof RewardCategory ? $cat : null;
    }

    private function getFolderName(): string
    {
        return $this->isPublished() ? 'Active' : 'Inactive';
    }
}
