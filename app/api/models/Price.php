<?php

namespace api\models;

use common\models\ProductWarehouse;

/**
 * Модель цен продукта.
 */
class Price extends ProductWarehouse
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