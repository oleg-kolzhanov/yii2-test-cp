<?php

namespace common\services;

use common\models\Product;
use common\models\ProductForm;
use common\models\ProductWarehouse;
use Yii;
use yii\db\Exception;

/**
 * Сервис продукта.
 */
class ProductService
{
    /**
     * Создание продукта.
     *
     * @param ProductForm $form Форма продукта
     * @param array|null $prices Цены и количества
     * @return Product
     * @throws Exception
     */
    public function create(ProductForm $form, ?array $prices): Product
    {
        $transaction = Yii::$app->db->beginTransaction();
        try {
            $product = new Product();
            $createdProduct = $product->saveOrFail(
                $form->name,
                $form->description,
                strtotime($form->manufactured_at)
            );
            foreach ($prices as $warehouseId => $price) {
                $productWarehouse = new ProductWarehouse();
                $productWarehouse->saveOrFail(
                    (int)$warehouseId,
                    $createdProduct->id,
                    (float)$price['cost'],
                    (int)$price['quantity']
                );
            }
        } catch (\DomainException $e) {
            $transaction->rollBack();
            throw $e;
        }
        $transaction->commit();

        return $createdProduct;
    }

    /**
     * Редактирование продукта.
     *
     * @param int $productId Идентификатор продукта
     * @param ProductForm $form Форма продукта
     * @param array|null $prices
     * @return Product
     * @throws Exception
     */
    public function edit(int $productId, ProductForm $form, ?array $prices): Product
    {
        $transaction = Yii::$app->db->beginTransaction();
        try {
            $product = $this->getProduct($productId);
            $product->saveOrFail(
                $form->name,
                $form->description,
                strtotime($form->manufactured_at)
            );
            ProductWarehouse::deleteAll(['product_id' => $product->id]);
            foreach ($prices as $warehouseId => $price) {
                $productWarehouse = new ProductWarehouse();
                $productWarehouse->saveOrFail(
                    (int)$warehouseId,
                    $product->id,
                    (float)$price['cost'],
                    (int)$price['quantity']
                );
            }
        } catch (\DomainException $e) {
            $transaction->rollBack();
            throw $e;
        }
        $transaction->commit();

        return $product;
    }

    /**
     * Возвращает продукт.
     *
     * @param int $productId Идентификатор продукта
     * @return Product
     */
    public function getProduct(int $productId): Product
    {
        $product = Product::findOne($productId);
        if (!$product) {
            throw new \DomainException('Такой продукт не найден');
        }
        return $product;
    }
}