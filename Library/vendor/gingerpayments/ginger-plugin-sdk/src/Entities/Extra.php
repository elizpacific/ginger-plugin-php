<?php

namespace GingerPluginSdk\Entities;

use GingerPluginSdk\Helpers\MultiFieldsEntityTrait;
use GingerPluginSdk\Helpers\SingleFieldTrait;
use GingerPluginSdk\Interfaces\ArbitraryArgumentsEntityInterface;
use GingerPluginSdk\Interfaces\MultiFieldsEntityInterface;
use phpDocumentor\Reflection\Types\This;

class Extra implements MultiFieldsEntityInterface, ArbitraryArgumentsEntityInterface
{
    use MultiFieldsEntityTrait;
    use SingleFieldTrait;

    protected string $propertyName = 'extra';

    public function __construct(
        ...$attributes
    )
    {
        foreach ($attributes as $attribute) {
            $key = key($attribute);
            $this->$key = $this->createSimpleField(
                propertyName: $key,
                value: $attribute[$key]
            );
        }
    }
}