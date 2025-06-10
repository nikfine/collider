<?php

namespace shared\validators;

use models\TracksModel;
use shared\types\TrackStatusType;
use yii\validators\Validator;

final class TrackStatusTypeValidator extends Validator
{
    /**
     * @param TracksModel $model
     * @param string $attribute
     * @return void
     */
    public function validateAttribute($model, $attribute): void
    {
        if (TrackStatusType::tryFrom($model->status) === null) {
            $model->addError($attribute, 'Track status is not valid');
        }
    }
}