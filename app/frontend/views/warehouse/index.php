<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\WarehouseSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Warehouses';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="warehouse-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create warehouse', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'code',
            'name',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Warehouse $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>
</div>
