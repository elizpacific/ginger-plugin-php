<?php

namespace GingerPluginSdk\Interfaces;

interface AbstractCollectionContainerInterface
{
    public function getPropertyName();

    public function toArray();

    public function getAll();
}