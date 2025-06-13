<?php

namespace modules\stats\controllers;

use modules\stats\services\StatsService;
use modules\stats\validators\StatsValidator;
use shared\rest\Controller;
use shared\validators\ValidatorCreator;
use Yii;

/**
 * @api
 */
class IndexController extends Controller
{
    public function actionIndex(): array
    {
        $validator = ValidatorCreator::fromGet(StatsValidator::class);
        if (!$validator->validate()) {
            return $validator->errors;
        }
        return Yii::$app->cache->getOrSet($this->request->get(), function () use ($validator) {
            return new StatsService()->get($validator);
        }, 60) ?? [];
    }
}