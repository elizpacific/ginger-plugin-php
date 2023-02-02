<?php

namespace GingerPluginSdk\Tests;

use GingerPluginSdk\Bases\BaseField;
use GingerPluginSdk\Collections\AbstractCollection;
use PHPUnit\Framework\TestCase;

class AbstractCollectionTest extends TestCase
{
    public function test_init()
    {
        $abstract_collection = new class('sore') extends AbstractCollection{};
        self::assertSame(
            expected: 0,
            actual: $abstract_collection->count()
        );
    }

    public function test_add_item_get_value()
    {
        $abstract_collection = new class('sore') extends AbstractCollection{};
        $abstract_collection->add('depression');
        self::assertSame(
            expected: 'depression',
            actual: $abstract_collection->get()
        );
    }

    public function test_add_item_get_pointer()
    {
        $abstract_collection = new class('sore') extends AbstractCollection{};
        $abstract_collection->add('depression');
        self::assertSame(
            expected: 0,
            actual: $abstract_collection->getCurrentPointer()
        );
    }

    public function test_remove_item_get_count()
    {
        $abstract_collection = new class('sore') extends AbstractCollection{};
        $abstract_collection->add('depression');
        $abstract_collection->add('obsession');
        $abstract_collection->add('all_will_be_fine');
        $abstract_collection->remove($abstract_collection->getCurrentPointer());
        self::assertSame(
            expected: 2,
            actual: $abstract_collection->count()
        );
    }

    public function test_remove_item_get_using_pointer()
    {
        $abstract_collection = new class('sore') extends AbstractCollection{};
        $abstract_collection->add('depression');
        $abstract_collection->add('obsession');
        $abstract_collection->add('all_will_be_fine');
        $expected = $abstract_collection->get(1);
        $abstract_collection->remove(0);
        self::assertSame(
            expected: $expected,
            actual: $abstract_collection->first()
        );
    }

    public function test_update_collection_item()
    {
        $abstract_collection = new class('sore') extends AbstractCollection{};
        $abstract_collection->add('depression');
        $abstract_collection->add('apple');
        $abstract_collection->update('ddepression', 1);
        self::assertSame(
            expected: 'ddepression',
            actual: $abstract_collection->get(1)
        );
    }

    public function test_get_all()
    {
        $std_object = new \stdClass();
        $std_object->check = true;
        $collection = new class('test') extends AbstractCollection{};
        $collection->add($std_object);
        self::assertSame(
            expected: [
                $std_object
            ],
            actual: $collection->getAll()
        );
    }

    public function test_different_item_types_not_allowed_object()
    {
        self::expectException(\InvalidArgumentException::class);
        $collection = new class('testing') extends AbstractCollection{};
        $collection->add(OrderStub::getValidLine());
        $collection->add(OrderStub::getValidCustomerAddress());
    }

    public function test_different_item_types_not_allowed_primitive()
    {
        self::expectException(\InvalidArgumentException::class);
        $collection = new class('testing') extends AbstractCollection{};
        $collection->add('1');
        $collection->add(1);
    }

}