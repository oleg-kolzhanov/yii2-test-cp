<?php

use common\components\helpers\PriceHelper;
use common\models\Product;
use common\models\ProductWarehouse;
use kartik\date\DatePicker;
use yii\helpers\Html;
use yii\helpers\StringHelper;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var common\models\search\ProductSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Продукты';
?>
<div class="product-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Создать продукт', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
                'attribute' => 'manufactured_at',
                'value' => function ($model) {
                    return Yii::$app->formatter->asDate($model->manufactured_at) . ' г.';
                },
                'filter' => DatePicker::widget([
                    'model' => $searchModel,
                    'attribute' => 'date_from',
                    'attribute2' => 'date_to',
                    'options' => ['placeholder' => 'Начальная'],
                    'options2' => ['placeholder' => 'Конечная'],
                    'type' => DatePicker::TYPE_RANGE,
                    'pluginOptions' => [
                        'format' => 'dd.mm.yyyy',
                        'autoclose' => true,
                    ]
                ])
            ],
            'name',
            [
                'attribute' => 'description',
                'value' => function ($model) {
                    return StringHelper::truncate($model->description, '50');
                },
            ],
            [
                'attribute' => 'prices',
                'label' => 'Склад и стоимость',
                'value' => function ($model) {
                    $priceAndWarehouse = '';
                    /** @var ProductWarehouse $price */
                    foreach ($model['prices'] as $price) {
                        if (!is_null($price->cost)) {
                            $priceAndWarehouse .=
                                $price->warehouse->name . ' — '
                                . PriceHelper::format($price->cost) . '<br>';
                        }
                    }
                    return $priceAndWarehouse;
                },
                'format' => 'raw',
            ],
            [
                'class' => ActionColumn::class,
                'urlCreator' => function ($action, Product $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                }
            ],
        ],
    ]); ?>
</div>
