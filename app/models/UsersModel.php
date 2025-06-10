<?php

namespace models;

use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * @property int $id
 * @property string $token
 * @property string $name
 */

final class UsersModel extends ActiveRecord implements IdentityInterface
{

    public static function tableName(): string
    {
        return 'users';
    }

    public static function findIdentity($id): UsersModel|IdentityInterface|null
    {
        return self::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null): UsersModel|IdentityInterface|null
    {
        return self::findOne(['token' => $token]);
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getAuthKey(): string
    {
        return $this->token;
    }

    public function validateAuthKey($authKey): bool
    {
        return $this->getAuthKey() === $authKey;
    }
}