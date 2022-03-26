<?php

namespace console\controllers;

use Yii;
use yii\helpers\Console;
use yii\console\Controller;

/**
 * Контроллер rbac доступов.
 */
class RbacController extends Controller
{
    /**
     * Имя разрешения для раздела продуктов.
     */
    const PERMISSION_PRODUCT_SECTION = 'productSection';

    /**
     * Имя разрешения для раздела складов.
     */
    const PERMISSION_WAREHOUSE_SECTION = 'warehouseSection';

    /**
     * Инициализация доступов.
     *
     * @return int
     * @throws \Exception
     */
    public function actionInit()
    {
        $auth = Yii::$app->getAuthManager();
        $auth->removeAll();

        $productSection = $auth->createPermission('productSection');
        $productSection->description = 'Product section';
        $auth->add($productSection);

        $warehouseSection = $auth->createPermission('warehouseSection');
        $warehouseSection->description = 'Warehouse section';
        $auth->add($warehouseSection);

        $admin = $auth->createRole('admin');
        $admin->description = 'Admin';
        $auth->add($admin);

        $auth->addChild($admin, $warehouseSection);
        $auth->addChild($admin, $productSection);

        $this->stdout("RBAC has been updated.\n", Console::FG_GREEN);

        return self::EXIT_CODE_NORMAL;
    }
}
