<?php
namespace shared\validators;

use yii\db\ActiveRecord;
use yii\validators\Validator;

final class DuplicateValidator extends Validator
{
    public ActiveRecord $targetClass;
    public string $targetAttribute;
    /** @var array<mixed>|null  */
    public array|null $filter = null;

    public function validateAttribute($model, $attribute): void
    {
        $query = $this->targetClass
            ::find()
            ->select([$this->targetAttribute])
            ->where([$this->targetAttribute => $model->$attribute]);
        if ($this->filter !== null && isset($model->id)) {
            $query->andWhere($this->filter);
        }
        $result = $query->all();
        $label = $model->getAttributeLabel($attribute) ?: $attribute;
        if ($result) {
            /** @var string|int|float $value */
            $value = $model->$attribute;
            $this->addError($model, $attribute, $this->message ?: "\"$label\" {$value} existed");
        }
    }
}
