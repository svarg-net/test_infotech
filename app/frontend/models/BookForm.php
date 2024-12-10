<?php

namespace frontend\models;

use yii\base\Model;

class BookForm extends Model
{
    public $title;
    public $year;
    public $description;
    public $isbn;
    public $photo;
    public $author_ids; // Для выбора авторов

    public function rules()
    {
        return [
            [['title', 'year', 'isbn', 'photo'], 'required'],
            [['year'], 'integer'],
            [['description'], 'string'],
            [['title', 'isbn', 'photo'], 'string', 'max' => 255],
            [['author_ids'], 'safe'], // Для авторов
        ];
    }

    public function attributeLabels()
    {
        return [
            'title' => 'Название',
            'year' => 'Год',
            'description' => 'Описание',
            'isbn' => 'ISBN',
            'photo' => 'Фото',
            'author_ids' => 'Авторы',
        ];
    }
}