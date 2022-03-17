<?php

use kartik\date\DatePicker;
use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\Product $model Модель продукта */
/** @var yii\widgets\ActiveForm $form */
//var_dump($model->warehouses);die();
?>
<div class="product-form">
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>

<!--    --><?//= $form->field($model, 'cost')->textInput() ?>
<!---->
<!--    --><?//= $form->field($model, 'quantity')->textInput() ?>

    <table class="table">
        <thead>
        <tr>
            <th scope="col">Наименование склада</th>
            <th scope="col">Стоимость</th>
            <th scope="col">Количество</th>
        </tr>
        </thead>
        <?php foreach ($model->warehouses as $key => $warehouse): ?>
            <tbody>
                <tr>
                    <td><?= $warehouse->name ?></td>
                </tr>
                <tr>
                    <td><?= $form->field($model, 'cost')->textInput() ?></td>
                </tr>
                <tr>
                    <td><?= $form->field($model, 'quantity')->textInput() ?></td>
                </tr>
            </tbody>
        <?php endforeach ?>
    </table>

    <?= $form->field($model, 'manufactured_at')->widget(DatePicker::class, [
        'language' => 'ru',
//        'name' => 'dp_2',
        'type' => DatePicker::TYPE_COMPONENT_PREPEND,
        'value' => (is_null($model->manufactured_at)) ?
            '' :
            Yii::$app->formatter->asDate($model->manufactured_at),
        'removeIcon' => 'x',
        'pluginOptions' => [
            'autoclose' => true,
            'format' => 'dd.mm.yyyy',
        ]
    ]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
