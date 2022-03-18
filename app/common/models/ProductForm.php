<?php

namespace common\models;

use yii\base\Model;
use yii\db\ActiveRecord;

/**
 * Форма продукта.
 */
class ProductForm extends Model
{
    /**
     * @var string Наименование товара
     */
    public $name;

    /**
     * @var string Описание товара
     */
    public $description;

    public $cost;

    public $quantity;

//    /**
//     * @var array[] Цены с количеством
//     */
//    public $prices;

    /**
     * @var string Дата изготовления
     */
    public $manufactured_at;

    /**
     * @var array|ActiveRecord[] Все склады
     */
    public $warehouses;

    /**
     * Конструктор формы.
     *
     * @param Product|null $product Модель продукта
     * @param $config
     */
    public function __construct(Product $product = null, $config = [])
    {
        $this->warehouses = Warehouse::find()->all();

        /** @var Warehouse $warehouse */
        foreach ($this->warehouses as $warehouse) {
//            $this->prices[$warehouse->id]['cost'] = $product->prices[$warehouse->id]['cost'];
//            $this->prices[$warehouse->id]['quantity'] = $product->prices[$warehouse->id]['quantity'];
            $this->cost[$warehouse->id] = $product->prices[$warehouse->id]['cost'];
            $this->quantity[$warehouse->id] = $product->prices[$warehouse->id]['quantity'];
        }

        $this->name = $product->name;
        $this->description = $product->description;
        $this->manufactured_at = $product->manufactured_at;
        parent::__construct($config);
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['name', 'manufactured_at'], 'required'],
            [['manufactured_at'], 'default', 'value' => null],
            [['manufactured_at'], 'string'],
            [['name'], 'string', 'max' => 150],
            [['description'], 'string', 'max' => 1500],
//            [['prices'], 'each', 'rule' => ['number']],
//            [['prices'], 'each', 'rule' => ['integer']],
//            ['prices', 'number', 'message' => 'Значение должно быть числом.'],

//            ['prices', 'number', 'when' => function ($model) {
//                return false;
////                return is_float($model->prices);
//            }],
        ];
    }

    /**
     * Лейблы атрибутов.
     *
     * @return string[]
     */
    public function attributeLabels(): array
    {
        return [
            'name' => 'Наименование товара',
            'description' => 'Описание товара',
            'manufactured_at' => 'Дата изготовления',
        ];
    }
}
