<?php

namespace api\models;

/**
 * Модель склада продукта.
 */
class ProductWarehouse extends \common\models\ProductWarehouse
{
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