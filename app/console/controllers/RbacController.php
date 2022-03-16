<?php

namespace console\controllers;

use Yii;
use yii\helpers\Console;
use yii\console\Controller;
use common\components\rbac\UserGroupRule;

/**
 * Контроллер rbac доступов.
 */
class RbacController extends Controller
{
    /**
     * Получить роли.
     *
     * @return array
     */
    public static function roles()
    {
        return [
            'guest' => 'Гость',
            'administrator' => 'Администратор',
        ];
    }

    /**
     * Инициализация доступов.
     *
     * @return int
     * @throws \Exception
     */
    public function actionInit()
    {
        $authManager = Yii::$app->authManager;
        $authManager->removeAll(); // Удаляем старые данные, чтобы не было конфликта (обязательно!).
        $userGroupRule = new UserGroupRule();
        $authManager->add($userGroupRule);
        foreach (static::roles() as $role => $description) {
            $$role = $authManager->createRole($role);
            $$role->ruleName = $userGroupRule->name;
            $authManager->add($$role);
            $$role->description = $description;
        }

        // Разрешения доступов по ролям (группам).
        $permission = [
            'guest' => [
                'route/app-frontend/site/error',
                'route/app-frontend/site/login',
            ],
            'administrator' => [
                'route/app-frontend/site/logout',
                'route/app-frontend/site/index'
            ],
        ];
        foreach ($permission as $role => $routes) {
            foreach ($routes as $route) {
                if (is_null($authManager->getPermission($route))) {
                    $permission = $authManager->createPermission($route);
                    $authManager->add($permission);
                }
                $authManager->addChild($authManager->getRole($role), $authManager->getPermission($route));
            }
        }

        $authManager->addChild($administrator, $guest);

        $this->stdout("RBAC has been updated.\n", Console::FG_GREEN);

        return self::EXIT_CODE_NORMAL;
    }
}
