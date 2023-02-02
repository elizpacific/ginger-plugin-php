<?php

namespace GingerPluginSdk\Tests;

use GingerPluginSdk\Collections\IdealIssuers;
use GingerPluginSdk\Entities\Issuer;
use PHPUnit\Framework\TestCase;

class IdealIssuersTest extends TestCase
{
    public function test_item_type()
    {
        self::assertSame(
            expected: Issuer::class,
            actual: IdealIssuers::ITEM_TYPE
        );
    }
    public function test_to_array()
    {
        $issuers = new IdealIssuers(
            new Issuer(
                id: 'ak12',
                listType: 'admin',
                name: 'bill'
            ),
            new Issuer(
                id: 'fp11',
                listType: 'custom',
                name: 'deposit'
            ),

        );
        self::assertSame(
            expected: [
                [
                    "id" => "ak12",
                    "list_type" => "admin",
                    "name" => "bill"
                ],
                [
                    "id" => "fp11",
                    "list_type" => "custom",
                    "name" => "deposit"
                ]
            ],

            actual: $issuers->toArray()
        );
    }

    public function test_get_property_name()
    {
        $issuers = new IdealIssuers(
            new Issuer(
                id: 'ak12',
                listType: 'admin',
                name: 'bill'
            ),
            new Issuer(
                id: 'fp11',
                listType: 'custom',
                name: 'deposit'
            ),

        );
        self::assertSame(
            expected: 'issuers',
            actual: $issuers->getPropertyName()
        );
    }

    public function test_add_issuer()
    {
        $issuers = new IdealIssuers();
        self::assertEqualsCanonicalizing(
            [
                'id' => '1',
                'name' => 'test_issuer',
                'list_type' => 'test'

            ],
            $issuers->addIssuer(item: new Issuer(
                id: '1',
                listType: 'test',
                name: 'test_issuer'
            ))->get()->toArray()
        );
    }

    public function test_remove_issuer()
    {
        $issuers = new IdealIssuers(
            new Issuer(
                id: 'ak12',
                listType: 'admin',
                name: 'bill'
            ),
            new Issuer(
                id: 'fp11',
                listType: 'custom',
                name: 'deposit'
            ),

        );
        self::assertEqualsCanonicalizing(
            [
                [
                    "id" => "ak12",
                    "list_type" => "admin",
                    "name" => "bill"
                ]
            ],
            $issuers->removeIssuer(1)->toArray()
        );
    }
}