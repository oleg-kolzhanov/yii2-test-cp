<?php

use common\models\User;
use yii\db\Migration;

/**
 * Добавляет администратора в таблицу пользователей.
 */
class m220316_174432_add_admin_to_user_table extends Migration
{
    /**
     * @var string Имя таблицы
     */
    public $table = '{{%user}}';

    /**
     * @var string Пароль
     */
    public $password = '123456';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $time = time();
        $values = [
            'username' => 'admin',
            'auth_key' => Yii::$app->security->generateRandomString(),
            'password_hash' => Yii::$app->security->generatePasswordHash($this->password),
            'password_reset_token' => null,
            'email' => 'test@admin.ru',
            'status' => 10,
            'created_at' => $time,
            'updated_at' => $time,
            'verification_token' => Yii::$app->security->generateRandomString(),
        ];

        $this->insert($this->table, $values);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m220316_174432_add_admin_to_user_table cannot be reverted.\n";

        return false;
    }
}
