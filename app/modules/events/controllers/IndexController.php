<?php

namespace modules\events\controllers;

use modules\events\services\EventsService;
use modules\events\validators\CreateEventValidator;
use modules\events\validators\DeleteEventsValidator;
use modules\events\validators\EventListValidator;
use shared\rest\Controller;
use shared\validators\ValidatorCreator;
use Yii;
use yii\db\Exception;

/**
 * @api
 */
class IndexController extends Controller
{
    public function actionIndex(): array
    {
        $validator = ValidatorCreator::fromGet(EventListValidator::class);
        if (!$validator->validate()) {
            return $validator->errors;
        }
        return Yii::$app->cache->getOrSet($this->request->get(), function () use ($validator) {
            return new EventsService()->list($validator);
        }, 60) ?? [];

    }

    /**
     * @throws Exception
     * @api
     */
    public function actionCreate(): array|null
    {
        $validator = ValidatorCreator::fromPost(CreateEventValidator::class);
        if (!$validator->validate()) {
            return $validator->errors;
        }
        new EventsService()->create($validator);
        return null;
    }

    /**
     * @api
     */
    public function actionDelete(): array|null
    {
        $validator = ValidatorCreator::fromPost(DeleteEventsValidator::class);
        if (!$validator->validate()) {
            return $validator->errors;
        }
        new EventsService()->delete($validator);
        return null;
    }
}