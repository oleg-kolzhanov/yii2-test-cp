<?php

namespace api\models;

use common\models\ProductWarehouse;
use common\models\Warehouse;
use yii\db\ActiveQuery;

/**
 * Модель цен продукта.
 */
class Price extends ProductWarehouse
{
    /**
     * Возвращает связь со складом.
     *
     * @return ActiveQuery
     */
    public function getWarehouse(): ActiveQuery
    {
        return $this->hasOne(Warehouse::class, ['id' => 'warehouse_id']);
    }

    /**
     * Ресурс склада продукта.
     *
     * @return Closure[]
     */
    public function fields(): array
    {
        return [
            'stock_code' => function () {
                return $this->warehouse->code;
            },
            'stock_name' => function () {
                return $this->warehouse->name;
            },
            'price' => function () {
                return $this->cost;
            },
        ];
    }
}