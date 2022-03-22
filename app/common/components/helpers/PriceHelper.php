<?php

namespace common\components\helpers;

/**
 * Класс для работы с ценой.
 */
class PriceHelper
{
    /**
     * Возвращает отформатированную цену.
     *
     * @param float $price
     * @return string
     */
    public static function format(float $price): string
    {
        return number_format($price, 2, ',', '&#x202F;') . '&#x202F;р.';
    }
}