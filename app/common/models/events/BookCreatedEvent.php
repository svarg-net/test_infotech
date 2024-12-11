<?php
namespace common\models\events;

use yii\base\Event;

class BookCreatedEvent extends Event
{
    public $book;
    public $message;
}