<?php
namespace api\controllers;

use yii\rest\ActiveController;

/**
 * Базовый REST API контнолер.
 * Class BaseController
 * @package common\controllers
 */
class ProductController extends ActiveController
{
   public $modelClass = 'api\models\Product';

    public function actionIndex()
   {
       return 'fsdf';
   }
}
