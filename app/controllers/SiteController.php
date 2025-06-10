<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;

/**
 * @api
 */
final class SiteController extends Controller
{
    /**
     * @api
     * @return string
     */
    public function actionError(): string
    {
        $exception = Yii::$app->errorHandler->exception;
        return $exception?->getMessage();
    }
}
