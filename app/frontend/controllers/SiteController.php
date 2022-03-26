<?php

namespace frontend\controllers;

use common\services\AuthService;
use Yii;
use yii\base\Module;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use yii\web\Controller;
use yii\web\Response;

/**
 * Контроллер сайта.
 */
class SiteController extends Controller
{
    /**
     * @var AuthService Сервис аутентификации
     */
    private $authService;

    /**
     * Конструктор.
     *
     * @param string $id Идентификатор контроллера
     * @param Module $module Модуль приложения
     * @param AuthService $authService Сервис аутентификации
     * @param $config
     */
    public function __construct(
        $id,
        $module,
        AuthService $authService,
        $config = []
    )
    {
        parent::__construct($id, $module, $config);
        $this->authService = $authService;
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Отображает домашнюю страницу.
     *
     * @return string
     */
    public function actionIndex(): string
    {
        return $this->render('index');
    }

    /**
     * Логинет пользователя.
     *
     * @return string|Response
     */
    public function actionLogin()
    {
        $this->layout = 'blanked';
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $form = new LoginForm();
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $user = $this->authService->auth($form);
                Yii::$app->user->login($user, $form->rememberMe ? Yii::$app->params['user.rememberMeDuration'] : 0);
                return $this->goBack();
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }

        return $this->render('login', [
            'model' => $form,
        ]);
    }

    /**
     * Разлогинивает пользователя.
     *
     * @return Response
     */
    public function actionLogout(): Response
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
}
