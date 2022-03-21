<?php

namespace frontend\controllers;

use common\controllers\BaseController;
use common\models\Warehouse;
use common\models\search\WarehouseSearch;
use common\models\WarehouseForm;
use common\services\WarehouseService;
use Yii;
use yii\base\Module;
use yii\db\StaleObjectException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;

/**
 * Контролер склада.
 */
class WarehouseController extends BaseController
{
    /**
     * @var Warehouse Модель склада
     */
    private $warehouse;

    /**
     * @var WarehouseSearch Модель данных склада и поиска по ним
     */
    private $warehouseSearch;

    /**
     * @var WarehouseService Сервис склада
     */
    private $warehouseService;

    /**
     * Конструктор.
     *
     * @param string $id Идентификатор контроллера
     * @param Module $module Модуль приложения
     * @param Warehouse $warehouse Модель склада
     * @param WarehouseSearch $warehouseSearch Модель данных склада и поиска по ним
     * @param WarehouseService $warehouseService Сервис склада
     * @param $config
     */
    public function __construct(
        $id,
        $module,
        Warehouse $warehouse,
        WarehouseSearch $warehouseSearch,
        WarehouseService $warehouseService,
        $config = []
    )
    {
        parent::__construct($id, $module, $config);
        $this->warehouse = $warehouse;
        $this->warehouseSearch = $warehouseSearch;
        $this->warehouseService = $warehouseService;
    }

    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::class,
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Список всех складов.
     *
     * @return string
     */
    public function actionIndex(): string
    {
        return $this->render('index', [
            'searchModel' => $this->warehouseSearch,
            'dataProvider' => $this->warehouseSearch->search($this->request->queryParams),
        ]);
    }

    /**
     * Склад.
     *
     * @param int $id Идентификатор склада
     * @return string
     * @throws NotFoundHttpException Если склад не был найден
     */
    public function actionView(int $id): string
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Создание склада.
     *
     * @return string|Response
     */
    public function actionCreate()
    {
        $form = new WarehouseForm(new Warehouse());
        if ($this->request->isPost) {
            if ($form->load($this->request->post()) && $form->validate()) {
                try {
                    $warehouse = $this->warehouseService->create($form);
                    Yii::$app->session->setFlash('success', 'Склад был успешно добавлен');
                    return $this->redirect(['view', 'id' => $warehouse->id]);
                } catch (\DomainException $e) {
                    Yii::$app->errorHandler->logException($e);
                    Yii::$app->session->setFlash('error', $e->getMessage());
                }
            }
        }

        return $this->render('create', [
            'model' => $form,
        ]);
    }

    /**
     * Обновление склада.
     *
     * @param int $id Идентификатор склада
     * @return string|Response
     * @throws NotFoundHttpException Если склад не был найден
     */
    public function actionUpdate(int $id)
    {
        $model = $this->findModel($id);
        $form = new WarehouseForm($model);
        if ($this->request->isPost && $form->load($this->request->post()) && $form->validate()) {
            try {
                $warehouse = $this->warehouseService->edit($model->id, $form);
                Yii::$app->session->setFlash('success', 'Склад был успешно обновлён');
                return $this->redirect(['view', 'id' => $warehouse->id]);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }

        return $this->render('update', [
            'form' => $form,
            'model' => $model,
        ]);
    }

    /**
     * Удаление склада.
     *
     * @param int $id Идентификатор склада
     * @return Response
     * @throws NotFoundHttpException Если склад не был найден
     * @throws StaleObjectException
     */
    public function actionDelete(int $id): Response
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Метод поиска склада.
     *
     * @param int $id Идентификатор склада
     * @return Warehouse
     * @throws NotFoundHttpException Если склад не был найден
     */
    protected function findModel(int $id): Warehouse
    {
        if (($model = $this->warehouse::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
