<?php

namespace common\services;

use common\models\Warehouse;
use common\models\WarehouseForm;

/**
 * Сервис склада.
 */
class WarehouseService
{
    /**
     * Создание склада.
     *
     * @param WarehouseForm $form Форма склада
     * @return Warehouse
     */
    public function create(WarehouseForm $form): Warehouse
    {
        $warehouse = new Warehouse();
        $warehouse->create($form->code, $form->name);

        return $warehouse;
    }
}