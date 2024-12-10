<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%user_author_subscription}}`.
 */
class m241210_145533_create_user_author_subscription_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%user_author_subscription}}', [
            'user_id' => $this->integer()->notNull(),
            'author_id' => $this->integer()->notNull(),
        ]);
        // Установка составного первичного ключа
        $this->addPrimaryKey('pk-user_author_subscription', '{{%user_author_subscription}}', ['user_id', 'author_id']);

        // Установка внешнего ключа для user_id
        $this->addForeignKey(
            'fk-user_author_subscription-user_id',
            '{{%user_author_subscription}}',
            'user_id',
            '{{%user}}', // Имя таблицы пользователей
            'id',
            'CASCADE'
        );

        // Установка внешнего ключа для author_id
        $this->addForeignKey(
            'fk-user_author_subscription-author_id',
            '{{%user_author_subscription}}',
            'author_id',
            '{{%authors}}', // Имя таблицы авторов
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-user_author_subscription-user_id', '{{%user_author_subscription}}');
        $this->dropForeignKey('fk-user_author_subscription-author_id', '{{%user_author_subscription}}');

        $this->dropTable('{{%user_author_subscription}}');
    }
}
