<?php

namespace frontend\controllers;

use common\models\Product;
use common\models\ProductForm;
use common\models\search\ProductSearch;
use common\services\ProductService;
use Yii;
use yii\base\Module;
use yii\db\StaleObjectException;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;

/**
 * Контроллер продукта.
 */
class ProductController extends Controller
{
    /**
     * @var Product Модель продукта
     */
    private $product;

    /**
     * @var ProductSearch Модель данных продукта и поиска по ним
     */
    private $productSearch;

    /**
     * @var ProductService Сервис продукта
     */
    private $productService;

    /**
     * Конструктор.
     *
     * @param string $id Идентификатор контроллера
     * @param Module $module Модуль приложения
     * @param Product $product Модель продукта
     * @param ProductSearch $productSearch Модель данных продукта и поиска по ним
     * @param ProductService $productService Сервис продукта
     * @param $config
     */
    public function __construct(
        $id,
        $module,
        Product $product,
        ProductSearch $productSearch,
        ProductService $productService,
        $config = []
    )
    {
        parent::__construct($id, $module, $config);
        $this->product = $product;
        $this->productSearch = $productSearch;
        $this->productService = $productService;
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
     * Список всех продуктов.
     *
     * @return string
     */
    public function actionIndex(): string
    {
        return $this->render('index', [
            'searchModel' => $this->productSearch,
            'dataProvider' => $this->productSearch->search($this->request->queryParams),
        ]);
    }

    /**
     * Продукт.
     *
     * @param int $id Идентификатор продукта
     * @return string
     * @throws NotFoundHttpException Если продукт не найден
     */
    public function actionView(int $id): string
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Создание продукта.
     *
     * @return string|Response
     */
    public function actionCreate()
    {
        $form = new ProductForm();
        if ($this->request->isPost) {
            if ($form->load($this->request->post()) && $form->validate()) {
                try {
                    $product = $this->productService->create($form);
                    Yii::$app->session->setFlash('success', 'Продукт был успешно добавлен');
                    return $this->redirect(['view', 'id' => $product->id]);
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
     * Обновление продукта.
     *
     * @param int $id Идентификатор продукта
     * @return string|Response
     * @throws NotFoundHttpException Если продукт не найден
     */
    public function actionUpdate(int $id)
    {
        $model = $this->findModel($id);
        $form = new ProductForm($model);
        if ($this->request->isPost && $form->load($this->request->post()) && $form->validate()) {
            try {
                $product = $this->productService->edit($model->id, $form);
                Yii::$app->session->setFlash('success', 'Продукт был успешно обновлён');
                return $this->redirect(['view', 'id' => $product->id]);
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
     * Удаление продукта.
     *
     * @param int $id Идентификатор продукта
     * @return Response
     * @throws NotFoundHttpException Если продукт не найден
     * @throws StaleObjectException
     */
    public function actionDelete(int $id): Response
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Метод поиска продукта.
     *
     * @param int $id Идентификатор продукта
     * @return Product
     * @throws NotFoundHttpException Если продукт не найден
     */
    protected function findModel(int $id): Product
    {
        if (($model = $this->product::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
