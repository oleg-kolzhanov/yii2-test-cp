<?php

namespace api\controllers;

use api\models\Product;
use api\components\Serializer;
use yii\data\ActiveDataProvider;
use yii\rest\Controller;

/**
 * Контроллер продуктов.
 */
class ProductController extends Controller
{
    /**
     * @var string $modelClass Модель продуктов
     */
    public $modelClass = Product::class;

    /**
     * Сериализация данных.
     *
     * @var array
     */
    public $serializer = [
        'class' => Serializer::class,
        'collectionEnvelope' => 'data',
    ];

    /**
     * Список продуктов.
     *
     * @return ActiveDataProvider
     */
    public function actionIndex(): ActiveDataProvider
    {
        return new ActiveDataProvider([
            'query' => Product::find()->with('prices.warehouse'),
        ]);
    }
}
