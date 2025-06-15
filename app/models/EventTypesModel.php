<?php

namespace models;

use yii\db\ActiveRecord;

/**
 * @property int $id
 * @property string $name
 */

class EventTypesModel extends ActiveRecord
{
    public static function tableName(): string
    {
        return 'event_types';
    }
}