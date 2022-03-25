<?php

namespace common\models;

use common\validators\PriceValidator;
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

    /**
     * @var array[] Цены с количеством
     */
    public $prices;

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

        if (!is_null($product)) {
            $prices = $product->getPrices()->indexBy('warehouse_id')->all();
        }

        /** @var Warehouse $warehouse */
        foreach ($this->warehouses as $warehouse) {
            $this->prices[$warehouse->id]['cost'] = $prices[$warehouse->id]['cost'];
            $this->prices[$warehouse->id]['quantity'] = $prices[$warehouse->id]['quantity'];
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
            ['prices', PriceValidator::class],
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
