<?php

namespace api\models;

use yii\db\ActiveQuery;

/**
 * Модель продукта.
 */
class Product extends \common\models\Product
{
    public function getPrices(): ActiveQuery
    {
        return $this->hasMany(ProductWarehouse::class, ['product_id' => 'id']);
    }

    /**
     * Ресурс продукта.
     *
     * @return array|false|int[]|string[]
     */
    public function fields()
    {
        $fields = parent::fields();
        unset($fields['id'], $fields['manufactured_at'], $fields['created_at'], $fields['updated_at']);
        return array_merge(
            $fields,
            [
                'prices' => function () {
                    return $this->prices;
                }
            ]
        );
    }
}