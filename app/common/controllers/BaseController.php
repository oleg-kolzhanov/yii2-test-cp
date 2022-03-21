<?php

namespace common\controllers;

use Yii;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;

/**
 * Базовый контроллер.
 */
class BaseController extends Controller
{
    /**
     * Проверка доступа перед действием.
     *
     * @inheritDoc
     * @param $action
     * @return bool
     * @throws BadRequestHttpException
     * @throws ForbiddenHttpException
     */
    public function beforeAction($action): bool
    {
        if (parent::beforeAction($action)) {
            if (Yii::$app->user->isGuest && ($action->id !== 'login')) {
                $this->redirect(['/site/login'])->send();
                return false;
            }
            $resourcePath = 'route/' . 'app-frontend' . '/'
                . ((Yii::$app->controller->module->id !== Yii::$app->id) ? Yii::$app->controller->module->id . '/' : '')
                . Yii::$app->controller->id
                . '/' . $action->id;
            if (!Yii::$app->user->can($resourcePath)) {
                throw new ForbiddenHttpException(Yii::t('app', 'Access denied'));
            }
            return true;
        }
        return false;
    }
}



