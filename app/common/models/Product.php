<?php

namespace common\models;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * Модель продукта.
 *
 * @property int $id Идентификатор продукта
 * @property string $name Наименование товара
 * @property string|null $description Описание товара
 * @property float|null $cost Стоимость товара
 * @property int|null $quantity Кол-во штук в наличии
 * @property int $manufactured_at Дата изготовления
 * @property int $created_at Временная метка создания записи
 * @property int $updated_at Временная метка обновления записи
 *
 * @property ProductWarehouse[] $productWarehouses Склады продукта
 */
class Product extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return '{{%product}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['name', 'manufactured_at'], 'required'],
            [['cost'], 'number'],
            [['quantity', 'manufactured_at', 'created_at', 'updated_at'], 'default', 'value' => null],
            [['quantity', 'manufactured_at', 'created_at', 'updated_at'], 'integer'],
            [['name'], 'string', 'max' => 150],
            [['description'], 'string', 'max' => 1500],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'description' => 'Description',
            'cost' => 'Cost',
            'quantity' => 'Quantity',
            'manufactured_at' => 'Manufactured At',
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
     * Возвращает связь со складами продукта.
     *
     * @return ActiveQuery
     */
    public function getProductWarehouses(): ActiveQuery
    {
        return $this->hasMany(ProductWarehouse::class, ['product_id' => 'id']);
    }
}
