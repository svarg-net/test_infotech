<?php

use yii\db\Migration;

/**
 * Class m241209_152659_add_test_users
 */
class m241209_152659_add_test_users extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        // Добавление тестовых пользователей
        $this->insert('user', [
            'username' => 'testuser1',
            'auth_key' => Yii::$app->security->generateRandomString(),
            'password_hash' => Yii::$app->security->generatePasswordHash('testuser1'),
            'email' => 'admin@example.com',
            'status' => 10, // 10 - активный статус
            'created_at' => time(),
            'updated_at' => time(),
        ]);

        $this->insert('user', [
            'username' => 'testuser2',
            'auth_key' => Yii::$app->security->generateRandomString(),
            'password_hash' => Yii::$app->security->generatePasswordHash('password2'),
            'email' => 'testuser2@example.com',
            'status' => 10, // 10 - активный статус
            'created_at' => time(),
            'updated_at' => time(),
        ]);

        $this->insert('user', [
            'username' => 'testguest',
            'auth_key' => Yii::$app->security->generateRandomString(),
            'password_hash' => Yii::$app->security->generatePasswordHash('password3'),
            'email' => 'testguest@example.com',
            'status' => 10, // 10 - активный статус
            'created_at' => time(),
            'updated_at' => time(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->delete('user', ['username' => 'testuser1']);
        $this->delete('user', ['username' => 'testuser2']);
        $this->delete('user', ['username' => 'testguest']);
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m241209_152659_add_test_users cannot be reverted.\n";

        return false;
    }
    */
}
