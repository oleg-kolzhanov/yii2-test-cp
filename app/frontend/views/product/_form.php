<?php

use common\models\Warehouse;
use kartik\date\DatePicker;
use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\ProductForm $model Форма продукта */
/** @var yii\widgets\ActiveForm $form */
?>
<div class="product-form">
    <?php $form = ActiveForm::begin([
        'enableClientValidation' => true,
    ]); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]); ?>

    <table class="table table-bordered">
        <?php /** @var Warehouse $warehouse */ ?>
        <?php foreach ($model->warehouses as $warehouse): ?>
            <tbody>
            <tr>
                <td><?= $warehouse->name ?></td>
                <td>
                    <?=
                    $form->field(
                        $model,
                        'prices[' . $warehouse->id . '][cost]',
                        [
                            'options' => ['data-cost' => 'true']
                        ]
                    )->textInput()->label('Стоимость товара');
                    ?>
                </td>
                <td>
                    <?=
                    $form->field(
                        $model,
                        'prices[' . $warehouse->id . '][quantity]',
                        [
                            'options' => ['data-quantity' => 'true']
                        ]
                    )->textInput()->label('Кол-во штук в наличии');
                    ?>
                </td>
            </tr>
            </tbody>
        <?php endforeach ?>
    </table>

    <?= $form->field($model, 'manufactured_at')->widget(DatePicker::class, [
        'language' => 'ru',
        'type' => DatePicker::TYPE_COMPONENT_PREPEND,
        'options' => [
            'value' => (is_null($model->manufactured_at)) ?
                date('d.m.Y') :
                Yii::$app->formatter->asDate($model->manufactured_at),
        ],
        'pluginOptions' => [
            'autoclose' => true,
            'todayHighlight' => true,
            'format' => 'dd.mm.yyyy'
        ]
    ]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
