<?php

namespace api\controllers;

use yii\rest\ActiveController;

/**
 * Контроллер продуктов.
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
        'collectionEnvelope' => 'data',
    ];

//    public function afterAction($action, $result)
//    {
//        $result = parent::afterAction($action, $result);
//        return $this->serializeData($result);
//    }
}
