<?php

namespace shared\rest;

use shared\Request;
use yii\web\Response;

/**
 * @property Request $request
 */
class Controller extends \yii\rest\Controller
{
    public function behaviors(): array
    {
        $behaviors = parent::behaviors();
        $behaviors['contentNegotiator']['formats']['text/html'] = Response::FORMAT_JSON;
        return $behaviors;
    }
}