<?php

namespace common\models;

use yii\base\Model;
use common\models\Warehouse;

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

    protected $warehouse;

    /**
     * Конструктор формы.
     *
     * @param Warehouse|null $warehouse Модель склада
     * @param $config
     */
    public function __construct(Warehouse $warehouse, $config = [])
    {
        $this->warehouse = $warehouse;
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
            ['code', 'unique', 'targetClass' => Warehouse::class, 'filter' => function ($query) {
                if (!$this->warehouse->isNewRecord) {
                    $query->andWhere(['not', ['id' => $this->warehouse->id]]);
                }
            }],
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
