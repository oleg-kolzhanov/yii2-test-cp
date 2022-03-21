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
 * @property float|null $cost Стоимость товара
 * @property int|null $quantity Кол-во штук в наличии
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
            [['warehouse_id', 'product_id', 'quantity', 'created_at', 'updated_at'], 'default', 'value' => null],
            [['warehouse_id', 'product_id', 'quantity', 'created_at', 'updated_at'], 'integer'],
            [['cost'], 'number'],
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
            'product_id' => 'product ID',
            'cost' => 'Стоимость товара',
            'quantity' => 'Кол-во штук в наличии',
            'created_at' => 'Временная метка создания записи',
            'updated_at' => 'Временная метка обновления записи',
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

    /**
     * Создание склада продукта
     *
     * @param int $warehouseId Идентификатор склада
     * @param int $productId Идентификатор продукта
     * @param float $cost Стоимость товара
     * @param int $quantity Кол-во штук в наличии
     * @return ProductWarehouse
     */
    public function saveOrFail(
        int $warehouseId,
        int $productId,
        float $cost,
        int $quantity
    ): ProductWarehouse
    {
        $this->warehouse_id = $warehouseId;
        $this->product_id = $productId;
        $this->cost = empty($cost) ? null : $cost;
        $this->quantity = empty($quantity) ? null : $quantity;
        if (!$this->save()) {
            throw new \DomainException('Ошибка добавления продукта на склад');
        }

        return $this;
    }
}
