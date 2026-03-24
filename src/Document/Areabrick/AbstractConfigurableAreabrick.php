<?php

declare(strict_types=1);

namespace App\Document\Areabrick;

use McSupply\EcommerceBundle\Twig\Components\CvaAwareInterface;
use Pimcore\Extension\Document\Areabrick\AbstractTemplateAreabrick;
use Pimcore\Extension\Document\Areabrick\EditableDialogBoxConfiguration;
use Pimcore\Extension\Document\Areabrick\EditableDialogBoxInterface;
use Pimcore\Model\Document;
use Pimcore\Model\Document\Editable;
use Pimcore\Model\Document\Editable\Area\Info;

abstract class AbstractConfigurableAreabrick extends AbstractTemplateAreabrick implements EditableDialogBoxInterface
{
    #[\Override]
    public function getEditableDialogBoxConfiguration(Document\Editable $area, ?Info $info): EditableDialogBoxConfiguration
    {
        $config = new EditableDialogBoxConfiguration();
        $config->setWidth(600);
        /** @var CvaAwareInterface $component */
        $component = new ($this->getComponentClassName());
        $items = [];

        foreach ($component->getVariants() as $name => $variant) {
            $item = new Editable\Select();
            $item->setName($name);
            $item->setLabel(ucfirst($name));
            $c = [];
            $defaultValue = $component->$name;

            if ($defaultValue !== null) {
                $c['defaultValue'] = $defaultValue;
            }

            foreach ($variant as $variantName => $variantValue) {
                $c['store'][] = [
                    $variantName, ucfirst($variantName),
                ];
            }

            $item->setConfig($c);
            $items[] = $item;
        }

        $config->setItems([$items]);
        $config->setReloadOnClose(true);

        return $config;
    }

    #[\Override]
    public function needsReload(): bool
    {
        return false;
    }

    abstract public function getComponentClassName(): string;
}
