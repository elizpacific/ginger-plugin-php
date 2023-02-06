<?php

namespace GingerPluginSdk\Helpers;

trait SyncUpSchemasTrait
{
    public function getJsonSchemaFromAPI($address)
    {
        print_r($_ENV);
        $curl = curl_init($_ENV['PUBLIC_SCHEMA_URL'] . $address . '.json');
        $result = curl_exec($curl);
        print_r(json_decode(
            $result,
            associative: true)
        );
        exit;
    }
}