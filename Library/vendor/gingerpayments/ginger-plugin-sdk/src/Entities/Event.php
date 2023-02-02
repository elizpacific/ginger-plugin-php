<?php

namespace GingerPluginSdk\Entities;

use GingerPluginSdk\Bases\BaseField;
use GingerPluginSdk\Helpers\HelperTrait;
use GingerPluginSdk\Helpers\MultiFieldsEntityTrait;
use GingerPluginSdk\Helpers\SingleFieldTrait;
use GingerPluginSdk\Interfaces\MultiFieldsEntityInterface;

class Event implements MultiFieldsEntityInterface
{
    use MultiFieldsEntityTrait;
    use SingleFieldTrait;
    use HelperTrait;

    private BaseField $event;

    public function __construct(
        string  $event,
        mixed   ...$additionalArguments
    )
    {
        $this->event = $this->createSimpleField(
            propertyName: 'event',
            value: $event
        );
        if ($additionalArguments) {
            $this->filterAdditionalProperties($additionalArguments);
        }
    }
}