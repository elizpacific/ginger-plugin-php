<?php

namespace GingerPluginSdk\Collections;

use GingerPluginSdk\Entities\Event;

class Events extends AbstractCollection
{
    const ITEM_TYPE = Event::class;

    public function __construct(Event ...$items)
    {
        $this->propertyName = 'events';
        foreach ($items as $item) {
            $this->add($item);
        }
        parent::__construct($this->propertyName);
    }

    public function addEvent(Event $item)
    {
        $this->add($item);
    }

    public function removeEvent($index)
    {
        $this->remove($index);
    }
}