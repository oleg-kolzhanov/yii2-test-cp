<?php

namespace common\bootstrap;

use Yii;
use yii\base\BootstrapInterface;

/**
 * Класс для настройки приложения перед запуском.
 *
 * @package common\bootstrap
 */
class SetUp implements BootstrapInterface
{
    /**
     * @inheritDoc
     */
    public function bootstrap($app)
    {
        $container = Yii::$container;
    }
}