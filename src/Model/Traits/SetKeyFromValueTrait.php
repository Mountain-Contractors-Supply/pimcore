<?php

declare(strict_types=1);

namespace App\Model\Traits;

use McSupply\EcommerceBundle\Utility\StringUtil;

trait SetKeyFromValueTrait
{
    /**
     * @param string $original
     * @param string $replace
     * @return void
     */
    public function setKeyFromValue(string $original, string $replace = ' & '): void
    {
        $key = trim(StringUtil::replaceInvalidKeyCharacters($original, $replace));

        if ($key !== $this->getKey()) {
            $this->setKey($key);
        }
    }
}
