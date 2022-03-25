<?php

use yii\db\Migration;

/**
 * Создаёт таблицу продуктов и складов.
 *
 * Имеет внешние ключи к таблицам:
 *
 * - `{{%warehouse}}`
 * - `{{%product}}`
 */
class m220317_124419_create_product_warehouse_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%product_warehouse}}', [
            'warehouse_id' => $this->integer()->notNull()->comment('Идентификатор склада'),
            'product_id' => $this->integer()->notNull()->comment('Идентификатор продукта'),
            'cost' => $this->float()->null()->comment('Стоимость товара'),
            'quantity' => $this->integer()->null()->comment('Кол-во штук в наличии'),
            'created_at' => $this->integer()->notNull()->comment('Временная метка создания записи'),
            'updated_at' => $this->integer()->notNull()->comment('Временная метка обновления записи'),
        ]);

        // Создаёт составной первичный ключ.
        $this->addPrimaryKey(
            '{{%product_warehouse_pkey}}',
            '{{%product_warehouse}}',
            ['warehouse_id', 'product_id']
        );

        // Создаёт индекс для поля `warehouse_id`
        $this->createIndex(
            '{{%idx-product_warehouse-warehouse_id}}',
            '{{%product_warehouse}}',
            'warehouse_id'
        );

        // Добавляет внешний ключ для таблицы `{{%warehouse}}`
        $this->addForeignKey(
            '{{%fk-product_warehouse-warehouse_id}}',
            '{{%product_warehouse}}',
            'warehouse_id',
            '{{%warehouse}}',
            'id',
            'CASCADE'
        );

        // Создаёт индекс для поля `product_id`
        $this->createIndex(
            '{{%idx-product_warehouse-product_id}}',
            '{{%product_warehouse}}',
            'product_id'
        );

        // Добавляет внешний ключ для таблицы `{{%product}}`
        $this->addForeignKey(
            '{{%fk-product_warehouse-product_id}}',
            '{{%product_warehouse}}',
            'product_id',
            '{{%product}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // Удаляет внешний ключ для таблицы `{{%warehouse}}`
        $this->dropForeignKey(
            '{{%fk-product_warehouse-warehouse_id}}',
            '{{%product_warehouse}}'
        );

        // Удаляет индекс для поля `warehouse_id`
        $this->dropIndex(
            '{{%idx-product_warehouse-warehouse_id}}',
            '{{%product_warehouse}}'
        );

        // Удаляет внешний ключ для таблицы `{{%product}}`
        $this->dropForeignKey(
            '{{%fk-product_warehouse-product_id}}',
            '{{%product_warehouse}}'
        );

        // Удаляет индекс для поля `product_id`
        $this->dropIndex(
            '{{%idx-product_warehouse-product_id}}',
            '{{%product_warehouse}}'
        );

        // Удаляет составной первичный ключ.
        $this->dropPrimaryKey(
            '{{%product_warehouse_pkey}}',
            '{{%product_warehouse}}'
        );

        $this->dropTable('{{%product_warehouse}}');
    }
}
