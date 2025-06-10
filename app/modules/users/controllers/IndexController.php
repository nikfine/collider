<?php

namespace modules\users\controllers;

use modules\users\services\UsersService;
use shared\rest\Controller;
use Yii;

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
        return Yii::$app->cache->getOrSet($id, function () use ($id) {
            return new UsersService()->events($id);
        }, 60);
    }
}