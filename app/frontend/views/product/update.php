<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\ProductForm $form Форма продукта */
/** @var common\models\Product $model Модель продукта */

$this->title = 'Обновить продукт: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Продукт', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Обновить';
?>
<div class="product-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $form,
    ]) ?>

</div>
