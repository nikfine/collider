<?php

namespace shared\auth;

use yii\web\IdentityInterface;

final class HttpBearerAuth extends \yii\filters\auth\HttpBearerAuth
{
    /**
     * @inheritdoc
     */
    public function authenticate($user, $request, $response): ?IdentityInterface
    {
        /** @var string|null $authHeader */
        $authHeader = $request->getHeaders()->get('Authorization');
        if ($authHeader === null || !preg_match('/^Bearer\s+(.*?)$/', $authHeader, $matches)) {
            return null;
        }
        $identity = $user->loginByAccessToken($matches[1], get_class($this));
        if ($identity === null) {
            return null;
        }
        return $identity;
    }
}
