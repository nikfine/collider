<?php

namespace shared;

class Request extends \yii\web\Request
{
    /**
     * @param $name
     * @param $defaultValue
     * @return ($name is null ? array<mixed> : mixed)
     */
    public function post($name = null, $defaultValue = null): mixed
    {
        return parent::post($name, $defaultValue);
    }

    /**
     * @param $name
     * @param $defaultValue
     * @return ($name is null ? array<mixed> : mixed)
     */
    public function get($name = null, $defaultValue = null): mixed
    {
        return parent::get($name, $defaultValue);
    }
}