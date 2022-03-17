<?php

namespace frontend\controllers;

use common\models\Warehouse;
use common\models\search\WarehouseSearch;
use common\models\WarehouseForm;
use common\services\WarehouseService;
use Yii;
use yii\base\Module;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;

/**
 * Контролер склада.
 */
class WarehouseController extends Controller
{
    /**
     * @var WarehouseSearch Модель данных накладных склада и поиска по ним
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
     * @param WarehouseSearch $warehouseSearch Модель данных накладных склада и поиска по ним
     * @param WarehouseService $warehouseService Сервис склада
     * @param $config
     */
    public function __construct(
        $id,
        $module,
        WarehouseSearch $warehouseSearch,
        WarehouseService $warehouseService,
        $config = []
    )
    {
        parent::__construct($id, $module, $config);
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
        $form = new WarehouseForm();

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
            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $form,
        ]);
    }

    /**
     * Обновление склада.
     *
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Удаление склада.
     *
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Метод поиска склада.
     *
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Warehouse the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Warehouse::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
