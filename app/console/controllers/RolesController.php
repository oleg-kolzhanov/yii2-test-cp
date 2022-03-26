<?php

namespace console\controllers;

use common\models\User;
use Yii;
use yii\console\Controller;
use yii\console\Exception;
use yii\helpers\ArrayHelper;
use yii\helpers\Console;

/**
 * Контроллер назначения ролей.
 */
class RolesController extends Controller
{
    /**
     * Добавление роли пользователю.
     * @throws Exception
     */
    public function actionAssign()
    {
        $username = $this->prompt('Username:', ['required' => true]);
        $user = $this->findModel($username);
        $roleName = $this->select('Role:', ArrayHelper::map(Yii::$app->authManager->getRoles(), 'name', 'description'));
        $authManager = Yii::$app->getAuthManager();
        $role = $authManager->getRole($roleName);
        $authManager->assign($role, $user->id);
        $this->stdout("Role has been assigned.\n", Console::FG_GREEN);
    }

    /**
     * Удаление роли у пользователя.
     * @throws Exception
     */
    public function actionRevoke()
    {
        $username = $this->prompt('Username:', ['required' => true]);
        $user = $this->findModel($username);
        $roleName = $this->select('Role:', ArrayHelper::merge(
            ['all' => 'All Roles'],
            ArrayHelper::map(Yii::$app->authManager->getRolesByUser($user->id), 'name', 'description'))
        );
        $authManager = Yii::$app->getAuthManager();
        if ($roleName == 'all') {
            $authManager->revokeAll($user->id);
        } else {
            $role = $authManager->getRole($roleName);
            $authManager->revoke($role, $user->id);
        }
        $this->stdout("Role has been revoked.\n", Console::FG_GREEN);
    }

    /**
     * Поиск модели пользователя.
     *
     * @param string $username
     * @throws Exception
     * @return User the loaded model
     */
    private function findModel($username): User
    {
        if (!$model = User::findOne(['username' => $username])) {
            throw new Exception('User is not found');
        }
        return $model;
    }
}