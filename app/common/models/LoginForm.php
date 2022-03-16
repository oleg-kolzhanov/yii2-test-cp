<?php

namespace common\models;

use Yii;
use yii\base\Model;

/**
 * Форма аутентификации.
 */
class LoginForm extends Model
{
    /**
     * @var string Емейл
     */
    public $email;

    /**
     * @var string Пароль
     */
    public $password;

    /**
     * @var bool Признак того, что пользователя нужно запомнить в системе
     */
    public $rememberMe = true;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['email', 'password'], 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['password', 'string', 'min' => Yii::$app->params['user.passwordMinLength']],
            ['rememberMe', 'boolean'],
        ];
    }

    /**
     * Лейблы атрибутов.
     *
     * @return string[]
     */
    public function attributeLabels()
    {
        return [
            'email' => 'E-mail',
            'password' => 'Пароль',
        ];
    }

//    /**
//     * Validates the password.
//     * This method serves as the inline validation for password.
//     *
//     * @param string $attribute the attribute currently being validated
//     * @param array $params the additional name-value pairs given in the rule
//     */
//    public function validatePassword($attribute, $params)
//    {
//        if (!$this->hasErrors()) {
//            $user = $this->getUser();
//            if (!$user || !$user->validatePassword($this->password)) {
//                $this->addError($attribute, 'Incorrect email or password.');
//            }
//        }
//    }

//    /**
//     * Logs in a user using the provided username and password.
//     *
//     * @return bool whether the user is logged in successfully
//     */
//    public function login()
//    {
//        if ($this->validate()) {
//            return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600 * 24 * 30 : 0);
//        }
//
//        return false;
//    }

//    /**
//     * Finds user by [[username]]
//     *
//     * @return User|null
//     */
//    protected function getUser()
//    {
//        if ($this->_user === null) {
//            $this->_user = User::findByUsername($this->email);
//        }
//
//        return $this->_user;
//    }
}
