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

    <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>

    <table class="table table-bordered">
        <?php /** @var Warehouse $warehouse */ ?>
        <?php foreach ($model->warehouses as $warehouse): ?>
            <tbody>
            <tr>
                <td><?= $warehouse->name ?></td>
                <td>
<!--                    --><?//=
//                        $form->field($model, 'prices[' . $warehouse->id . '][cost]')
//                            ->textInput()->label('Стоимость товара')
//                    ?>

                    <?=
                        $form->field($model, 'cost[' . $warehouse->id . ']')
                            ->textInput()->label('Стоимость товара')
                    ?>
                </td>
                <td>
<!--                    --><?//=
//                        $form->field($model, 'prices[' . $warehouse->id . '][quantity]')
//                            ->textInput()->label('Кол-во штук в наличии')
//                    ?>

                    <?=
                        $form->field($model, 'quantity[' . $warehouse->id . ']')
                            ->textInput()->label('Кол-во штук в наличии')
                    ?>
                </td>
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
