<?php

namespace GingerPluginSdk\Collections;

use GingerPluginSdk\Collections\AbstractCollection;
use GingerPluginSdk\Entities\Line;

final class OrderLines extends AbstractCollection
{
    const ITEM_TYPE = Line::class;

    public function __construct(Line ...$items)
    {
        $this->propertyName = 'order_lines';
        foreach ($items as $item) {
            $this->add($item);
        }
        parent::__construct('order_lines');
    }

    public function getLine($index = null): Line
    {
        return $this->get($index);
    }

    public function addLine(Line $item)
    {
        $this->add($item);
        return $this;
    }

    public function removeLine($index)
    {
        $this->remove($index);
        return $this;
    }

    public function updateLine(Line $line, $index = 0)
    {
        $this->update($line->toArray(), $index);
        return $this;
    }
}