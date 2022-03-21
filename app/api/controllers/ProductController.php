<?php
namespace api\controllers;

use common\models\Product;
use common\models\Warehouse;
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
     * @var array
     */
    public $serializer = [
        'class' => 'yii\rest\Serializer',
        'collectionEnvelope' => 'items',
    ];

    /**
     * Возвращает список товаров.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $model = new $this->modelClass();
        return $model->with('prices');
    }
}
