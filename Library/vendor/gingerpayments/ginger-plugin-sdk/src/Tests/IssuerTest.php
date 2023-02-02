<?php

namespace GingerPluginSdk\Tests;

use GingerPluginSdk\Entities\Issuer;
use PHPUnit\Framework\TestCase;

class IssuerTest extends TestCase
{
    public function test_valid_issuer()
    {
        self::expectNotToPerformAssertions();
        new Issuer(
            id: '123',
            listType: 'bank',
            name: 'Derschutze'
        );
    }

    public function test_issuer_to_array()
    {
        self::assertSame(
            expected: [
                'id' => '123',
                'list_type' => 'bank',
                'name' => 'Derschutze'
            ],
            actual: (new Issuer(
                id: '123',
                listType: 'bank',
                name: 'Derschutze'
            ))->toArray()
        );
    }

    public function test_get_id()
    {
        $issuer = new Issuer(
            id: '1',listType: 'enigma',name: 'bl'
        );
        self::assertSame(
            expected: '1',
            actual: $issuer->getId()
        );
    }
}