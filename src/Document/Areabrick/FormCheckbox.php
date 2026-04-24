<?php

declare(strict_types=1);

namespace App\Document\Areabrick;

use Pimcore\Extension\Document\Areabrick\Attribute\AsAreabrick;
use Pimcore\Model\Document\Editable;
use Pimcore\Model\Document\Editable\Area\Info;
use Symfony\Component\HttpFoundation\Response;

#[AsAreabrick(id: 'form-checkbox')]
final class FormCheckbox extends AbstractConfigurableAreabrick
{
    public function getName(): string
    {
        return 'Checkbox Field';
    }

    public function getDescription(): string
    {
        return 'A checkbox input field with style and size variants';
    }

    public function getComponentClassName(): string
    {
        return \McSupply\EcommerceBundle\Twig\Components\Form\Checkbox::class;
    }

    protected function getFieldPropertiesItems(): array
    {
        return [
            (new Editable\Input())->setName('name')->setLabel('Field Name'),
            (new Editable\Checkbox())->setName('checked')->setLabel('Checked by Default'),
            (new Editable\Checkbox())->setName('disabled')->setLabel('Disabled'),
        ];
    }

    #[\Override]
    public function action(Info $info): ?Response
    {
        parent::action($info);

        $info->setParam('name', $info->getDocumentElement('name')?->getData() ?? 'checkbox');
        $info->setParam('checked', (bool) $info->getDocumentElement('checked')?->getData());
        $info->setParam('disabled', (bool) $info->getDocumentElement('disabled')?->getData());

        return null;
    }
}
