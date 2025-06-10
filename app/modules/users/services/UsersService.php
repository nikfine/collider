<?php

namespace modules\users\services;

use models\EventsModel;

class UsersService
{
    public function events(int $id): array
    {
        return EventsModel::find()
            ->where(['user_id' => $id])
            ->orderBy(['id' => SORT_DESC])
            ->limit(1000)
            ->asArray()
            ->all();
    }
}