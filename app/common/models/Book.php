<?php
namespace common\models;

use common\models\events\BookCreatedEvent;
use yii\db\ActiveRecord;

class Book extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%books}}';
    }

    public function rules()
    {
        return [
            [['title', 'year', 'isbn', 'photo'], 'required'],
            [['year'], 'integer'],
            [['description'], 'string'],
            [['title', 'isbn', 'photo'], 'string', 'max' => 255],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Название',
            'year' => 'Год',
            'description' => 'Описание',
            'isbn' => 'ISBN',
            'photo' => 'Фото',
            'author_ids' => 'Авторы'
        ];
    }

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);

        if ($insert) {
            $event = new BookCreatedEvent();
            $event->book = $this;
            $event->message = 'Новая книга от ' . implode(', ', array_map(function($author) {
                    return $author->full_name;
                }, $this->authors)) . ': ' . $this->title;
            $this->trigger('bookCreated', $event);
        }
    }

    public function init()
    {
        parent::init();
        $this->on('bookCreated', [$this, 'sendSmsNotificationsToSubscribers']);
    }

    public function sendSmsNotificationsToSubscribers(BookCreatedEvent $event)
    {
        $book = $event->book;
        $message = $event->message;
        $authors = $book->authors;
        foreach ($authors as $author) {
            $subscribers = $author->getSubscribers()->all();
            foreach ($subscribers as $subscriber) {
                $this->sendSms($subscriber->phone, $message);
            }
        }
    }

    public function sendSms($phone, $message)
    {
        $apiKey = 'XXXXXXXXXXXXYYYYYYYYYYYYZZZZZZZZXXXXXXXXXXXXYYYYYYYYYYYYZZZZZZZZ';
        $url = 'https://smspilot.ru/api2/send.php';
        $data = [
            'apikey' => $apiKey,
            'to' => $phone,
            'message' => $message,
        ];

        $options = [
            'http' => [
                'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                'method'  => 'POST',
                'content' => http_build_query($data),
            ],
        ];

        $context  = stream_context_create($options);
        $result = file_get_contents($url, false, $context);

        if ($result === FALSE) {
            echo "Ошибка при отправке SMS-сообщения.";
        } else {
            echo "SMS-сообщение отправлено: " . $result;
        }
    }
    public function getAuthors()
    {
        return $this->hasMany(Author::className(), ['id' => 'author_id'])
            ->viaTable('{{%book_authors}}', ['book_id' => 'id']);
    }
}

