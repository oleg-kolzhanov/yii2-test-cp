<?php

namespace common\models;

use yii\base\Model;

/**
 * Форма склада.
 */
class WarehouseForm extends Model
{
    /**
     * @var integer Код склада
     */
    public $code;

    /**
     * @var string Наименование склада
     */
    public $name;

    /**
     * Конструктор формы.
     *
     * @param Warehouse|null $warehouse Модель склада
     * @param $config
     */
    public function __construct(Warehouse $warehouse = null, $config = [])
    {
        $this->code = $warehouse->code;
        $this->name = $warehouse->name;
        parent::__construct($config);
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['code', 'name'], 'required'],
            [['code'], 'default', 'value' => null],
            [['code'], 'integer'],
            [['name'], 'string', 'max' => 150],
//            ['code', 'unique', 'targetClass' => '\common\models\Warehouse', 'message' => 'Такой код уже существует.'],
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
            'code' => 'Код',
            'name' => 'Наименование',
        ];
    }
}
