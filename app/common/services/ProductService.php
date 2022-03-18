<?php

namespace common\services;

use common\models\Product;
use common\models\ProductForm;

/**
 * Сервис продукта.
 */
class ProductService
{
    /**
     * Создание продукта.
     *
     * @param ProductForm $form Форма продукта
     * @return Product
     */
    public function create(ProductForm $form): Product
    {
        var_dump($form);die();
        $product = new Product();
        $product->create(
            $form->name,
            $form->description,
            $form->cost,
            $form->quantity,
            strtotime($form->manufactured_at)
        );

        return $product;
    }

    /**
     * Редактирование продукта.
     *
     * @param int $productId Идентификатор продукта
     * @param ProductForm $form Форма продукта
     * @return Product
     */
    public function edit(int $productId, ProductForm $form): Product
    {
        $product = $this->getProduct($productId);
        $product->edit(
            $form->name,
            $form->description,
            $form->cost,
            $form->quantity,
            strtotime($form->manufactured_at)
        );

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