<?php

namespace common\models;

use yii\db\ActiveRecord;

class Author extends ActiveRecord
{
    public function rules()
    {
        return [
            [['full_name'], 'required'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'full_name' => 'ФИО',
        ];
    }
    public static function tableName()
    {
        return '{{%authors}}';
    }

    public function getBooks()
    {
        return $this->hasMany(Book::className(), ['id' => 'book_id'])
            ->viaTable('{{%book_authors}}', ['author_id' => 'id']);
    }

    public function getSubscribers(){
        return $this->hasMany(User::className(), ['id' => 'user_id'])
            ->viaTable('user_author_subscription', ['author_id' => 'id']);
    }
}