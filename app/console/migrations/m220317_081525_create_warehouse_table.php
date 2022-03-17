<?php

use yii\db\Migration;

/**
 * Создаёт таблицу складов.
 */
class m220317_081525_create_warehouse_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%warehouse}}', [
            'id' => $this->primaryKey()->comment('Идентификатор склада'),
            'code' => $this->integer()->notNull()->unique()->comment('Код склада'),
            'name' => $this->string(150)->notNull()->comment('Наименование склада'),
            'created_at' => $this->integer()->notNull()->comment('Временная метка создания записи'),
            'updated_at' => $this->integer()->notNull()->comment('Временная метка обновления записи'),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%warehouse}}');
    }
}
