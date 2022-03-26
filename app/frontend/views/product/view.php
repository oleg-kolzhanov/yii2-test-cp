<?php

use common\components\helpers\PriceHelper;
use common\models\ProductWarehouse;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Product */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Продукты', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="product-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Обновить', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы уверены, что хотите это удалить ?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'name',
            'description',
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
                                . Yii::$app->formatter->asCurrency($price->cost) . '<br>';
                        }
                    }
                    return $priceAndWarehouse;
                },
                'format' => 'raw',
            ],
            [
                'attribute' => 'manufactured_at',
                'value' => function ($model) {
                    return Yii::$app->formatter->asDate($model->manufactured_at);
                },
            ],
        ],
    ]) ?>
</div>
