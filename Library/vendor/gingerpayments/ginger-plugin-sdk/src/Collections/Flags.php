<?php

namespace GingerPluginSdk\Collections;

class Flags extends AbstractCollection
{
    const ITEM_TYPE = 'String';

    public function __construct(string ...$flags)
    {
        $this->propertyName = 'flags';

        foreach ($flags as $flag) {
            $this->add($flag);
        }

        parent::__construct('flags');
    }
}