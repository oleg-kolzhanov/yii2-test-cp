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
//            'cost' => 'Стоимость товара',
//            'quantity' => 'Кол-во штук в наличии',
            'manufactured_at' => 'Дата изготовления',
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
     * @return ActiveQuery
     */
    public function getPrices()
    {
        return $this->hasMany(ProductWarehouse::class, ['product_id' => 'id']);
    }

    /**
     * Создание продукта.
     *
     * @param string $name Наименование товара
     * @param string $description Описание товара
     * @param float $cost Стоимость товара
     * @param int $quantity Кол-во штук в наличии
     * @param int $manufacturedAt Дата изготовления
     * @return Product
     */
    public function create(
        string $name,
        string $description,
        float $cost,
        int $quantity,
        int $manufacturedAt
    ): Product
    {
        $this->name = $name;
        $this->description = $description;
        $this->cost = $cost;
        $this->quantity = $quantity;
        $this->manufactured_at = $manufacturedAt;
        $this->saveOrFail();

        return $this;
    }

    /**
     * Редактирование продукта.
     *
     * @param string $name Наименование товара
     * @param string $description Описание товара
     * @param float $cost Стоимость товара
     * @param int $quantity Кол-во штук в наличии
     * @param int $manufacturedAt Дата изготовления
     * @return Product
     */
    public function edit(
        string $name,
        string $description,
        float $cost,
        int $quantity,
        int $manufacturedAt
    ): Product
    {
        $this->name = $name;
        $this->description = $description;
        $this->cost = $cost;
        $this->quantity = $quantity;
        $this->manufactured_at = $manufacturedAt;
        $this->saveOrFail();

        return $this;
    }

    /**
     * Сохраняет модель.
     *
     * @return void
     */
    public function saveOrFail()
    {
        if (!$this->save()) {
            throw new \DomainException('Ошибка добавления склада');
        }
    }
}
