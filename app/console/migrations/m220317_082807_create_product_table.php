<?php

use yii\db\Migration;

/**
 * Создаёт таблицу продуктов.
 */
class m220317_082807_create_product_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%product}}', [
            'id' => $this->primaryKey()->comment('Идентификатор продукта'),
            'name' => $this->string(150)->notNull()->comment('Наименование товара'),
            'description' => $this->string(1500)->null()->comment('Описание товара'),
            'cost' => $this->float()->null()->comment('Стоимость товара'),
            'quantity' => $this->integer()->null()->comment('Кол-во штук в наличии'),
            'manufactured_at' => $this->integer()->notNull()->comment('Дата изготовления'),
            'created_at' => $this->integer()->notNull()->comment('Временная метка создания записи'),
            'updated_at' => $this->integer()->notNull()->comment('Временная метка обновления записи'),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%product}}');
    }
}
