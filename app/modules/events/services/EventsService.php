<?php

namespace modules\events\services;

use models\EventsModel;
use modules\events\validators\CreateEventValidator;
use modules\events\validators\DeleteEventsValidator;
use modules\events\validators\EventListValidator;
use yii\db\Exception;

class EventsService
{
    /**
     * @param EventListValidator $validator
     * @return array
     */
    public function list(EventListValidator $validator): array
    {
        return EventsModel::find()
            ->limit($validator->limit)
            ->offset($validator->page * $validator->limit)
            ->asArray()
            ->all();
    }

    /**
     * @param CreateEventValidator $validator
     * @return void
     * @throws Exception
     */
    public function create(CreateEventValidator $validator): void
    {
        $event = new EventsModel();
        $event->setAttributes($validator->getAttributes(), false);
        $event->save();
    }

    /**
     * @param DeleteEventsValidator $validator
     * @return void
     */
    public function delete(DeleteEventsValidator $validator): void
    {
        EventsModel::deleteAll(['<', 'timestamp', $validator->before]);
    }
}