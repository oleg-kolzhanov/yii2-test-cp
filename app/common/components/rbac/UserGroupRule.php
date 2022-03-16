<?php

namespace common\components\rbac;

use Yii;
use yii\rbac\Rule;
use common\models\User;

/**
 * Класс ролей групп.
 *
 * @package common\components\rbac
 */
class UserGroupRule extends Rule
{
    /**
     * Название правила.
     *
     * @var string
     */
    public $name = 'userGroup';

    /**
     * Выполнить правило.
     *
     * @param string|integer $user the user ID. This should be either an integer or a string representing
     *        the unique identifier of a user. See [[\yii\web\User::id]].
     * @param Item $item the role or permission that this rule is associated with
     * @param array $params parameters passed to [[ManagerInterface::checkAccess()]].
     * @return boolean a value indicating whether the rule permits the auth item it is associated with.
     */
    public function execute($user, $item, $params)
    {
        if (Yii::$app->user->isGuest) {
            $group = User::GROUP_GUEST;
        } else {
            $group = Yii::$app->user->identity->group;
        }
        switch ($item->name) {
            case 'administrator':
                return $group == User::GROUP_ADMINISTRATOR;
                break;
            case 'guest':
                return true;
                break;
        }
        return false;
    }
}
