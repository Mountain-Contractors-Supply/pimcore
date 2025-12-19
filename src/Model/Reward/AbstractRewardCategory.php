<?php

declare(strict_types=1);

namespace App\Model\Reward;

use App\EventListener\PreAddUpdateAwareInterface;
use App\Model\AbstractModel;
use App\Model\Traits\SetKeyFromValueTrait;
use Exception;
use McSupply\EcommerceBundle\Dto\Reward\RewardCategoryInterface;
use McSupply\EcommerceBundle\Dto\Reward\RewardInterface;

abstract class AbstractRewardCategory extends AbstractModel implements RewardCategoryInterface, PreAddUpdateAwareInterface
{
    use SetKeyFromValueTrait;

    public function onPreAdd(): void
    {
        $this->setName($this->getKey());
        $this->onPreUpdate();
    }

    public function onPreUpdate(): void
    {
        $this->setKeyFromValue((string)$this->getName());
    }

    /**
     * @throws Exception
     */
    public function addReward(RewardInterface $reward): void
    {
        $rewards = $this->getRewards();

        if (!in_array($reward, $rewards ?? [], true)) {
            $rewards[] = $reward;
            $this->setRewards($rewards);
            $this->save();
        }
    }
}
