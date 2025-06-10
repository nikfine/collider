<?php

namespace modules\events\controllers;

use models\EventsModel;
use modules\events\validators\DeleteEventsValidator;
use modules\events\validators\EventListValidator;
use shared\rest\Controller;
use Yii;
use yii\db\Exception;
use yii\web\HttpException;

/**
 * @api
 */
class IndexController extends Controller
{
    /**
     * @throws HttpException
     */
    public function actionIndex(): array
    {
        $validator = new EventListValidator();
        $validator->setAttributes($this->request->get());
        if (!$validator->validate()) {
            throw new HttpException(400, 'Invalid request');
        }
        return EventsModel::find()
            ->offset(($validator->page - 1) * $validator->limit)
            ->limit($validator->limit)
            ->all();
    }

    /**
     * @throws Exception
     * @throws HttpException
     * @api
     */
    public function actionCreate(): void
    {
        $event = new EventsModel();
        $event->setAttributes($this->request->post());
        if (!$event->validate()) {
            throw new HttpException(400, 'Invalid request');
        }
        $event->save();
    }

    /**
     * @throws HttpException
     * @api
     */
    public function actionDelete(): void
    {
        $validator = new DeleteEventsValidator();
        $validator->setAttributes($this->request->get());
        if (!$validator->validate()) {
            throw new HttpException(400, 'Invalid request');
        }
        EventsModel::deleteAll(['<', 'timestamp', $validator->before]);
    }
}