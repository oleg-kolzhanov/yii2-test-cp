<?php

namespace common\models;

use yii\base\Model;

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

    /**
     * @var float Стоимость товара
     */
    public $cost;

    /**
     * @var int Кол-во штук в наличии
     */
    public $quantity;

    /**
     * @var string Дата изготовления
     */
    public $manufactured_at;

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
        $this->name = $product->name;
        $this->description = $product->description;
        $this->cost = $product->cost;
        $this->quantity = $product->quantity;
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
            [['cost'], 'number'],
            [['quantity', 'manufactured_at'], 'default', 'value' => null],
            [['quantity'], 'integer'],
            [['manufactured_at'], 'string'],
            [['name'], 'string', 'max' => 150],
            [['description'], 'string', 'max' => 1500],
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
            'cost' => 'Стоимость товара',
            'quantity' => 'Кол-во штук в наличии',
            'manufactured_at' => 'Дата изготовления',
        ];
    }
}
