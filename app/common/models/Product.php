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
 * @property int $manufactured_at Дата изготовления
 * @property int $created_at Временная метка создания записи
 * @property int $updated_at Временная метка обновления записи
 *
 * @property ProductWarehouse[] $productWarehouses Склады продукта
 * @property Warehouse[] $warehouses Склады
 * @property ProductWarehouse[] $prices Цены и склады
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
            [['manufactured_at', 'created_at', 'updated_at'], 'default', 'value' => null],
            [['manufactured_at', 'created_at', 'updated_at'], 'integer'],
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
            'name' => 'Наименование товара',
            'description' => 'Описание товара',
            'manufactured_at' => 'Дата изготовления',
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
     * Возвращает связь со складами продукта.
     *
     * @return ActiveQuery
     */
    public function getProductWarehouses(): ActiveQuery
    {
        return $this->hasMany(ProductWarehouse::class, ['product_id' => 'id']);
    }

    /**
     * Возвращает связь со складами.
     *
     * @return ActiveQuery
     */
    public function getWarehouses(): ActiveQuery
    {
        return $this->hasMany(Warehouse::class, ['id' => 'warehouse_id'])
            ->via(ProductWarehouse::class, ['product_id' => 'id']);
    }

    /**
     * Возвращает связь с ценами и количеством.
     *
     * @return ActiveQuery
     */
    public function getPrices(): ActiveQuery
    {
        return $this->hasMany(ProductWarehouse::class, ['product_id' => 'id']);
    }

    /**
     * Сохранение продукта.
     *
     * @param string $name Наименование товара
     * @param string $description Описание товара
     * @param int $manufacturedAt Дата изготовления
     * @return Product
     */
    public function saveOrFail(
        string $name,
        string $description,
        int $manufacturedAt
    ): Product
    {
        $this->name = $name;
        $this->description = $description;
        $this->manufactured_at = $manufacturedAt;
        if (!$this->save()) {
            throw new \DomainException('Ошибка сохранения продукта');
        }

        return $this;
    }
}
