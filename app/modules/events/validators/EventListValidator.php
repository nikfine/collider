<?php

namespace modules\events\validators;

use yii\base\Model;

class EventListValidator extends Model
{
    public int|null $page = null;
    public int|null $limit = null;

    public function rules(): array
    {
        return [[['page', 'limit'], 'required'], [['page', 'limit'], 'integer']];
    }
}