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
    /**
     * @return array<mixed>
     */
    public function rules(): array
    {
        return [
            [['user_id', 'type_id', 'metadata'], 'required'],
            [['user_id', 'type_id'], 'number'],
            [['id', 'timestamp'], 'safe'],
        ];
    }

    public static function tableName(): string
    {
        return 'events';
    }
}