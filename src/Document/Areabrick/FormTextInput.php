<?php

declare(strict_types=1);

namespace App\Document\Areabrick;

use Pimcore\Extension\Document\Areabrick\Attribute\AsAreabrick;
use Pimcore\Model\Document\Editable;
use Pimcore\Model\Document\Editable\Area\Info;
use Symfony\Component\HttpFoundation\Response;

#[AsAreabrick(id: 'form-text-input')]
final class FormTextInput extends AbstractConfigurableAreabrick
{
    public function getName(): string
    {
        return 'Text Input Field';
    }

    public function getDescription(): string
    {
        return 'A text input field with size variants';
    }

    public function getComponentClassName(): string
    {
        return \McSupply\EcommerceBundle\Twig\Components\Form\TextInput::class;
    }

    /**
     * @return array<int, mixed>
     */
    protected function getFieldPropertiesItems(): array
    {
        return [
            (new Editable\Input())->setName('name')->setLabel('Field Name'),
            (new Editable\Input())->setName('id')->setLabel('Field ID'),
            (new Editable\Input())->setName('label')->setLabel('Label Text'),
            (new Editable\Input())->setName('type')->setLabel('Input Type (text, email, tel, etc.)')->setConfig(['defaultValue' => 'text']),
            (new Editable\Input())->setName('placeholder')->setLabel('Placeholder Text'),
            (new Editable\Checkbox())->setName('disabled')->setLabel('Disabled'),
            (new Editable\Checkbox())->setName('required')->setLabel('Required'),
        ];
    }

    #[\Override]
    public function action(Info $info): ?Response
    {
        parent::action($info);

        $info->setParam('name', $info->getDocumentElement('name')?->getData() ?? 'input');
        $info->setParam('id', $info->getDocumentElement('id')?->getData() ?? '');
        $info->setParam('label', $info->getDocumentElement('label')?->getData() ?? 'Label');
        $info->setParam('type', $info->getDocumentElement('type')?->getData() ?: 'text');
        $info->setParam('placeholder', $info->getDocumentElement('placeholder')?->getData() ?? '');
        $info->setParam('value', '');
        $info->setParam('disabled', (bool) $info->getDocumentElement('disabled')?->getData());
        $info->setParam('required', (bool) $info->getDocumentElement('required')?->getData());

        return null;
    }
}
