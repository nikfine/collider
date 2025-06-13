<?php

namespace models;

use yii\db\ActiveRecord;

/**
 * @property int $id
 * @property int $user_id
 * @property int $type_id
 * @property string $timestamp
 * @property string $metadata
 */
final class EventsModel extends ActiveRecord
{
    public static function tableName(): string
    {
        return 'events';
    }
}