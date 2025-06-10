<?php

namespace modules\events\controllers;

use modules\events\services\EventsService;
use shared\rest\Controller;
use Yii;
use yii\db\Exception;
use yii\web\HttpException;

/**
 * @api
 */
class IndexController extends Controller
{
    public function actionIndex(): array
    {
        return Yii::$app->cache->getOrSet($this->request->get(), function () {
            return new EventsService()->list($this->request->get());
        }, 60) ?? [];

    }

    /**
     * @throws Exception
     * @throws HttpException
     * @api
     */
    public function actionCreate(): void
    {
        new EventsService()->create($this->request->post());
    }

    /**
     * @throws HttpException
     * @api
     */
    public function actionDelete(): void
    {
        new EventsService()->delete($this->request->post());
    }
}