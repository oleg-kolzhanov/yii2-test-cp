<?php

namespace api\controllers;

use yii\rest\ActiveController;

/**
 * Базовый REST API контнолер.
 *
 * Class BaseController
 * @package common\controllers
 */
class ProductController extends ActiveController
{
    /**
     * @var string $modelClass Модель продуктов
     */
    public $modelClass = 'api\models\Product';

    /**
     * Сериализация данных.
     *
     * @var array
     */
    public $serializer = [
        'class' => 'yii\rest\Serializer',
        'collectionEnvelope' => 'items',
    ];

    /**
     * Отключаем стандартные Action.
     *
     * Ниже, задаём свои.
     * {@inheritdoc}
     */
    public function actions()
    {
        $actions = parent::actions();

        unset($actions['delete'], $actions['create'], $actions['update'], $actions['index']);
        return $actions;
    }

    /**
     * Возвращает список товаров.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $model = new $this->modelClass();
        return $model::find()->with('prices')->asArray()->all();
    }
}
