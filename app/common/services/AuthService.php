<?php

namespace common\services;

use common\models\LoginForm;
use common\models\User;

/**
 * Сервис аутентификации.
 */
class AuthService
{
    /**
     * Аутентификация.
     *
     * @param LoginForm $form Форма аутентификации
     * @return User
     */
    public function auth(LoginForm $form): User
    {
        $user = User::findByUsername($form->email);
        if (!$user || !$user->isActive() || !$user->validatePassword($form->password)) {
            throw new \DomainException('Incorrect email or password.');
        }
        return $user;
    }
}