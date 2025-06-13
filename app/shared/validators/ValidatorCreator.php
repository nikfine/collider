<?php

namespace shared\validators;

use Yii;
use yii\base\Model;

final class ValidatorCreator
{
    /**
     * @template T of Model
     * @param class-string<T> $className
     * @return T
     */
    public static function fromPost(string $className)
    {
        return self::fromArray($className, Yii::$app->request->post());
    }

    /**
     * @template T of Model
     * @param class-string<T> $className
     * @return T
     */
    public static function fromGet(string $className)
    {
        return self::fromArray($className, Yii::$app->request->get());
    }

    /**
     * @template T of Model
     * @param class-string<T> $className
     * @param array $data
     * @return T
     */
    public static function fromArray(string $className, array $data)
    {
        $validator = new $className();
        $validator->setAttributes($data);
        return $validator;
    }
}