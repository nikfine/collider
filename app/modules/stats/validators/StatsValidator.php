<?php

namespace modules\stats\validators;

use yii\base\Model;

class StatsValidator extends Model
{
    public string|null $from = null;
    public string|null $to = null;
    public string|null $type = null;

    public function rules()
    {
        return [
            [['from', 'to', 'type'], 'required'],
            [['from', 'to'], 'datetime', 'format' => 'php:Y-m-d H:i:s'],
        ];
    }
}