<?php

namespace modules\events\services;

use models\EventsModel;
use modules\events\validators\DeleteEventsValidator;
use modules\events\validators\EventListValidator;
use yii\db\Exception;
use yii\web\HttpException;

class EventsService
{
    /**
     * @throws HttpException
     */
    public function list(array $requestData): array
    {
        $validator = new EventListValidator();
        $validator->setAttributes($requestData);
        if (!$validator->validate()) {
            throw new HttpException(400, json_encode($validator->errors));
        }
        return EventsModel::find()
            ->limit($validator->limit)
            ->offset($validator->page * $validator->limit)
            ->asArray()
            ->all();
    }

    /**
     * @throws Exception
     * @throws HttpException
     */
    public function create(array $requestData): void
    {
        $event = new EventsModel();
        $event->setAttributes($requestData);
        if (!$event->validate()) {
            throw new HttpException(400, json_encode($event->errors));
        }
        $event->save();
    }

    /**
     * @throws HttpException
     */
    public function delete(array $requestData): void
    {
        $validator = new DeleteEventsValidator();
        $validator->setAttributes($requestData);
        if (!$validator->validate()) {
            throw new HttpException(400, json_encode($validator->errors));
        }
        EventsModel::deleteAll(['<', 'timestamp', $validator->before]);
    }
}