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

    /**
     * Редактирование склада.
     *
     * @param int $warehouseId Идентификатор склада
     * @param WarehouseForm $form Форма склада
     * @return Warehouse
     */
    public function edit(int $warehouseId, WarehouseForm $form): Warehouse
    {
        $warehouse = $this->getWarehouse($warehouseId);
        $warehouse->edit($warehouseId, $form->code, $form->name);

        return $warehouse;
    }

    /**
     * Возвращает склад.
     *
     * @param int $warehouseId Идентификатор склада
     * @return Warehouse
     */
    public function getWarehouse(int $warehouseId): Warehouse
    {
        $warehouse = Warehouse::findOne($warehouseId);
        if (!$warehouse) {
            throw new \DomainException('Такой склад не найден');
        }
        return $warehouse;
    }
}