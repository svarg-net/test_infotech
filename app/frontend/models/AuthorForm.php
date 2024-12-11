<?php

namespace frontend\models;

use yii\base\Model;

class AuthorForm extends Model
{
    public $full_name;

    public function rules()
    {
        return [
            [['full_name'], 'required'],
            [['full_name'], 'string', 'max' => 255],
        ];
    }

    public function attributeLabels()
    {
        return [
            'full_name' => 'ФИО',
        ];
    }
}