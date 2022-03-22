<?php

namespace api\controllers;

use api\models\Product;
use yii\rest\ActiveController;
use api\components\Serializer;

/**
 * Контроллер продуктов.
 */
class ProductController extends ActiveController
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
}
