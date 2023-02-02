<?php

namespace GingerPluginSdk\Entities;

use GingerPluginSdk\Bases\BaseField;
use GingerPluginSdk\Helpers\MultiFieldsEntityTrait;
use GingerPluginSdk\Helpers\SingleFieldTrait;
use GingerPluginSdk\Interfaces\MultiFieldsEntityInterface;

class Issuer implements MultiFieldsEntityInterface
{
    use MultiFieldsEntityTrait;
    use SingleFieldTrait;

    private BaseField $id;
    private BaseField $listType;
    private BaseField $name;

    public function __construct(
        string $id,
        string $listType,
        string $name
    )
    {
        $this->id = $this->createSimpleField(
            propertyName: 'id',
            value: $id
        );

        $this->listType = $this->createSimpleField(
            propertyName: 'list_type',
            value: $listType
        );

        $this->name = $this->createSimpleField(
            propertyName: 'name',
            value: $name
        );
    }

    /**
     * Get current issuer id
     *
     * @return string
     */
    public function getId(): string
    {
        return $this->id->get();
    }
}