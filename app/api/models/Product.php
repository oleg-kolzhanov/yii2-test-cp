<?php

namespace api\models;

use yii\db\ActiveQuery;

/**
 * Модель продукта.
 */
class Product extends \common\models\Product
{
    /**
     * Возвращает связь со складами продукта.
     *
     * @return ActiveQuery
     */
    public function getPrices(): ActiveQuery
    {
        return $this->hasMany(Price::class, ['product_id' => 'id']);
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
            ['prices']
        );
    }

    /**
     * Переводит объект в массив.
     *
     * @param array $fields
     * @param array $expand
     * @param bool $recursive
     * @return array
     */
    public function toArray(array $fields = [], array $expand = [], $recursive = true)
    {
        $data = [];
        foreach ($this->resolveFields($fields, $expand) as $field => $definition) {
            $attribute = is_string($definition) ? $this->$definition : $definition($this, $field);

            $data[$field] = $attribute;
        }
        return $data;
    }
}