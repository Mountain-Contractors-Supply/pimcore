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
use Symfony\Component\HttpFoundation\Response;

abstract class AbstractConfigurableAreabrick extends AbstractTemplateAreabrick implements EditableDialogBoxInterface
{
    private readonly CvaAwareInterface $component;

    public function __construct()
    {
        $class = $this->getComponentClassName();

        // Ensure the runtime class actually implements the required interface
        if (!is_a($class, CvaAwareInterface::class, true)) {
            throw new \RuntimeException(sprintf(
                'Component class "%s" must implement %s',
                $class,
                CvaAwareInterface::class
            ));
        }

        $this->component = new $class();

    }

    #[\Override]
    public function getEditableDialogBoxConfiguration(Document\Editable $area, ?Info $info): EditableDialogBoxConfiguration
    {
        $config = new EditableDialogBoxConfiguration();
        $config->setWidth(600);
        $items = [];

        foreach ($this->component->getVariants() as $name => $variant) {
            $item = new Editable\Select();
            $item->setName($name);
            $item->setLabel(ucfirst($name));
            $c = ['defaultValue' => $this->getDefaultValue($name, $info)];

            foreach ($variant as $variantName => $variantValue) {
                $c['store'][] = [
                    $variantName, ucfirst($variantName),
                ];
            }

            $item->setConfig($c);
            $items[] = $item;
        }

        $tabItems = [
            [
                'type' => 'panel',
                'title' => 'Variants',
                'items' => $items,
            ],
            [
                'type' => 'panel',
                'title' => 'Advanced',
                'items' => [
                    (new Editable\Input())
                        ->setName('additionalClasses')
                        ->setLabel('Additional Classes'),
                ]
            ],
        ];

        $fieldProperties = $this->getFieldPropertiesItems();
        if ($fieldProperties !== []) {
            $tabItems[] = [
                'type' => 'panel',
                'title' => 'Field Properties',
                'items' => $fieldProperties,
            ];
        }

        $config->setItems(['type' => 'tabpanel', 'items' => $tabItems]);

        $config->setReloadOnClose(true);

        return $config;
    }

    /**
     * @throws \Exception
     */
    #[\Override]
    public function action(Info $info): ?Response
    {
        $variantValues = [];

        foreach ($this->component->getVariants() as $name => $variant) {
            $data = $info->getDocumentElement($name);
            $variantValues[$name] = $data !== null && !$data->isEmpty()
                ? $data->getData()
                : $this->getDefaultValue($name, $info);
        }

        $info->setParam('variantValues', $variantValues);
        $info->setParam('additionalClasses', $info->getDocumentElement('additionalClasses') ?? '');

        return null;
    }

    abstract public function getComponentClassName(): string;

    /**
     * @return array<int, mixed>
     */
    protected function getFieldPropertiesItems(): array
    {
        return [];
    }

    private function getDefaultValue(string $name, ?Info $info): string
    {
        $customDefaults = [];

        if ($info !== null) {
            $params = $info->getParams();
            $customDefaults = $params['variantValues'] ?? [];
        }

        return $customDefaults[$name] ?? $this->component->getDefaultVariantValue($name);
    }
}
