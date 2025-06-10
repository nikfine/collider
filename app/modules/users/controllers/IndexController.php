<?php

namespace modules\users\controllers;

use models\EventsModel;
use shared\rest\Controller;

/**
 * @api
 */
class IndexController extends Controller
{
    /**
     * @api
     */
    public function actionEvents(int $id): array
    {
        return EventsModel::find()
            ->where(['user_id' => $id])
            ->orderBy(['id' => SORT_DESC])
            ->limit(1000)
            ->all();
    }
}