<?php

namespace GingerPluginSdk\Tests;

use GingerPluginSdk\Collections\Events;
use GingerPluginSdk\Entities\Event;
use GingerPluginSdk\Entities\Extra;

class EventsTest extends \PHPUnit\Framework\TestCase
{
    public function test_item_type()
    {
        self::assertSame(
            expected: Event::class,
            actual: Events::ITEM_TYPE
        );
    }

    public function test_add_event()
    {
        $event = new Event(
            event: 'new',
            occurred: '2022-05-17T11:58:33.813534+00:00',
            source: '123',
            noticed: '2022-05-17T11:58:33.813534+00:00',
            id: '123'
        );
        $events = new Events();
        $events->addEvent($event);
        self::assertSame(
            expected: $event,
            actual: $events->get()
        );
    }

    public function test_remove_event()
    {
        $event = new Event(
            event: 'new',
            occurred: '2022-05-17T11:58:33.813534+00:00',
            source: '123',
            noticed: '2022-05-17T11:58:33.813534+00:00',
            id: '123'
        );
        $events = new Events($event);
        $events->removeEvent($events->getCurrentPointer());
        self::assertSame(
            expected: 0,
            actual: $events->count()
        );
    }
}