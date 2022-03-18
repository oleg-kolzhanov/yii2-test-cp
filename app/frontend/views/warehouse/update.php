<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\WarehouseForm $form Форма склада */
/** @var common\models\Warehouse $model Модель склада */

$this->title = 'Обновить склад: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Склады', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Обновить';
?>
<div class="warehouse-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $form,
    ]) ?>

</div>
