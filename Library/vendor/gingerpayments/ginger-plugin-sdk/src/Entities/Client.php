<?php

namespace GingerPluginSdk\Entities;

use GingerPluginSdk\Bases\BaseField;
use GingerPluginSdk\Helpers\MultiFieldsEntityTrait;
use GingerPluginSdk\Helpers\SingleFieldTrait;
use GingerPluginSdk\Interfaces\MultiFieldsEntityInterface;


final class Client implements MultiFieldsEntityInterface
{
    use MultiFieldsEntityTrait;
    use SingleFieldTrait;

    protected string $propertyName = 'client';
    private BaseField $userAgent;
    private BaseField $platformName;
    private BaseField $platformVersion;
    private BaseField $pluginName;
    private BaseField $pluginVersion;

    /**
     * @param string|null $userAgent - HTTP user agent
     * @param string|null $platformName - Name of the software used to connect to the API, e.g. Magento Community Edition
     * @param string|null $platformVersion - Version of the software used to connect to the API, e.g. 1.9.2.2
     * @param string|null $pluginName - Name of the plugin used to connect to the API, e.g. ginger-magento
     * @param string|null $pluginVersion - Version of the plugin used to connect to the API, e.g. 1.0.0
     */
    public function __construct(
        string  $userAgent = null,
        ?string $platformName = null,
        ?string $platformVersion = null,
        ?string $pluginName = null,
        ?string $pluginVersion = null
    )
    {
        $this->userAgent = $this->createSimpleField(
            propertyName: 'user_agent',
            value: $userAgent
        );
        $this->platformName = $this->createSimpleField(
            propertyName: 'platform_name',
            value: $platformName
        );
        $this->platformVersion = $this->createSimpleField(
            propertyName: 'platform_version',
            value: $platformVersion
        );
        $this->pluginName = $this->createSimpleField(
            propertyName: 'plugin_name',
            value: $pluginName
        );
        $this->pluginVersion = $this->createSimpleField(
            propertyName: 'plugin_version',
            value: $pluginVersion
        );
    }

    public function getUserAgent(): BaseField
    {
        return $this->userAgent;
    }

    public function getPlatformName(): BaseField
    {
        return $this->platformName;
    }

    public function getPlatformVersion(): BaseField
    {
        return $this->platformVersion;
    }

    public function getPluginName(): BaseField
    {
        return $this->pluginName;
    }

    public function getPluginVersion(): BaseField
    {
        return $this->pluginVersion;
    }
}