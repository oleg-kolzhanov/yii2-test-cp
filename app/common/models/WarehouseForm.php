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
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['code', 'name'], 'required'],
            [['code', 'created_at', 'updated_at'], 'default', 'value' => null],
            [['code', 'created_at', 'updated_at'], 'integer'],
            [['name'], 'string', 'max' => 150],
            [['code'], 'unique'],
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
