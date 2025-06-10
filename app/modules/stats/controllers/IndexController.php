<?php

namespace modules\stats\controllers;

use modules\stats\services\StatsService;
use shared\rest\Controller;
use Yii;

/**
 * @api
 */
class IndexController extends Controller
{
    public function actionIndex(): array
    {
        return Yii::$app->cache->getOrSet(md5(serialize($this->request->get())), function () {
            return new StatsService()->get($this->request->get());
        }, 60) ?? [];
    }
}