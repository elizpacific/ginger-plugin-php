<?php

namespace GingerPluginSdk\Properties;

use GingerPluginSdk\Exceptions\EmptyApiKeyException;
use function PHPUnit\Framework\throwException;

class ClientOptions
{
    /**
     * @param string $endpoint
     * @param bool $useBundle
     * @param string $apiKey
     */
    public function __construct(
        public string $endpoint,
        public bool   $useBundle,
        public string $apiKey
    )
    {
        if (empty($this->apiKey)) {
            throw new EmptyApiKeyException('Client can\'t be initialized with empty API Key');
        }
    }
}