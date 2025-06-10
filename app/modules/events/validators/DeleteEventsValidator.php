<?php

namespace modules\events\validators;

use yii\base\Model;

class DeleteEventsValidator extends Model
{
    public string|null $before = null;

    public function rules(): array
    {
        return [[['before'], 'required'], [['before'], 'datetime', 'format' => 'php:Y-m-d H:i:s']];
    }
}