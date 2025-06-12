<?php

namespace models;

use yii\db\ActiveRecord;

class EventTypesModel extends ActiveRecord
{
    public static function tableName(): string
    {
        return 'event_types';
    }
}