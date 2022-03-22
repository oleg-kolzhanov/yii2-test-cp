<?php

namespace common\validators;

use yii\validators\Validator;

/**
 * Валидатор цены.
 */
class PriceValidator extends Validator
{
    /**
     * Инициализация.
     */
    public function init()
    {
        parent::init();

        $this->message = 'custom validator.';
    }

    /**
     * {@inheritdoc}
     */
    public function validateAttribute($model, $attribute)
    {
        $value = $model->$attribute;
    }

    /**
     * {@inheritdoc}
     */
    public function clientValidateAttribute($model, $attribute, $view)
    {
        $costMessage = json_encode('«Стоимость» должно быть числом.', JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        $quantityMessage = json_encode('«Кол-во» должно быть целым числом.', JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        return <<<JS
        let intReg = /^[+-]?\d+$/;
        let numberReg = /^[-+]?[0-9]*\.?[0-9]+([eE][-+]?[0-9]+)?$/;
        let input = $(this.input);
        if (input.parent().data('cost') && input.val() !== '') {
            if (!numberReg.test(input.val())) {
                messages.push($costMessage);
            }
        }
        if (input.parent().data('quantity') && input.val() !== '') {
            if (!intReg.test(input.val())) {
                messages.push($quantityMessage);
            }
        }
JS;
    }
}