<?php

namespace modules\events\validators;

use models\EventTypesModel;
use models\UsersModel;
use yii\base\Model;

class CreateEventValidator extends Model
{
    public ?int $user_id = null;
    public ?int $type_id = null;
    public ?array $metadata = null;

    /**
     * @return array<mixed>
     */
    public function rules(): array
    {
        return [
            [['user_id', 'type_id', 'metadata'], 'required'],
            [['user_id', 'type_id'], 'number'],
            [['type_id'], function () {
                if (!EventTypesModel::findOne(['id' => $this->type_id])) {
                    $this->addError('type_id', 'Invalid event type');
                }
            }],
            [['user_id'], function () {
                if (!UsersModel::findOne(['id' => $this->user_id])) {
                    $this->addError('user_id', 'Invalid user');
                }
            }],
        ];
    }
}