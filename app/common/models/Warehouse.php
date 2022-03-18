<?php

namespace common\models;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * Модель склада.
 *
 * @property int $id Идентификатор склада
 * @property int $code Код склада
 * @property string $name Наименование склада
 * @property int $created_at Временная метка создания записи
 * @property int $updated_at Временная метка обновления записи
 *
 * @property ProductWarehouse[] $productWarehouses Продукты склада
 */
class Warehouse extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%warehouse}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
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
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'code' => 'Код',
            'name' => 'Наименование',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
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
     * Возвращает связь с продуктами склада.
     *
     * @return ActiveQuery
     */
    public function getProductWarehouses(): ActiveQuery
    {
        return $this->hasMany(ProductWarehouse::class, ['warehouse_id' => 'id']);
    }

    /**
     * Создание склада.
     *
     * @param int $code Код
     * @param string $name Наименование
     * @return $this
     */
    public function create(int $code, string $name): Warehouse
    {
        $this->checkCode($code);
        $this->code = $code;
        $this->name = $name;
        $this->saveOrFail();

        return $this;
    }

    /**
     * Редактирование склада.
     *
     * @param int $warehouseId Идентификатор склада
     * @param int $code Код
     * @param string $name Наименование
     * @return $this
     */
    public function edit(int $warehouseId, int $code, string $name): Warehouse
    {
        $this->checkCode($code, $warehouseId);
        $this->code = $code;
        $this->name = $name;
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

    /**
     * Проверка на существование кода.
     *
     * @param int $code Код
     * @param int|null $warehouseId Идентификатор склада
     * @return void
     */
    public function checkCode(int $code, ?int $warehouseId = null)
    {
        $codeCheck = self::find()->andWhere(['code' => $code]);
        if (!is_null($warehouseId)) {
            $codeCheck->andWhere(['<>', 'id', $warehouseId]);
        }
        if ($codeCheck->exists()) {
            throw new \DomainException('Такой код уже существует.');
        }
    }
}
