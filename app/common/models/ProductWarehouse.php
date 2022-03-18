<?php

namespace common\models;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * Модель связи склада с продуктом.
 *
 * @property int $id Идентификатор связи склада с продуктом
 * @property int $warehouse_id Идентификатор склада
 * @property int $product_id Идентификатор продукта
 * @property int $created_at Временная метка создания записи
 * @property int $updated_at Временная метка обновления записи
 *
 * @property Product $product Продукт
 * @property Warehouse $warehouse Склад
 */
class ProductWarehouse extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return '{{%product_warehouse}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['warehouse_id', 'product_id'], 'required'],
            [['warehouse_id', 'product_id', 'created_at', 'updated_at'], 'default', 'value' => null],
            [['warehouse_id', 'product_id', 'created_at', 'updated_at'], 'integer'],
            [
                ['product_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => Product::class,
                'targetAttribute' => ['product_id' => 'id']
            ],
            [
                ['warehouse_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => Warehouse::class,
                'targetAttribute' => ['warehouse_id' => 'id']
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'warehouse_id' => 'warehouse ID',
            'product_id' => 'Product ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors(): array
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => 'updated_at'
            ],
        ];
    }

    /**
     * Возвращает связь с продуктом.
     *
     * @return ActiveQuery
     */
    public function getProduct(): ActiveQuery
    {
        return $this->hasOne(Product::class, ['id' => 'product_id']);
    }

    /**
     * Возвращает связь со складом.
     *
     * @return ActiveQuery
     */
    public function getWarehouse(): ActiveQuery
    {
        return $this->hasOne(Warehouse::class, ['id' => 'warehouse_id']);
    }
}
