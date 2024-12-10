<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $book common\models\Book */

$this->title = Html::encode($book->title);
$this->params['breadcrumbs'][] = ['label' => 'Книги', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<h1><?= Html::encode($this->title) ?></h1>

<div class="book-view">
    <p>
        <strong>Название:</strong> <?= Html::encode($book->title) ?><br>
        <strong>Год публикации:</strong> <?= Html::encode($book->year) ?><br>
        <strong>Описание:</strong> <?= Html::encode($book->description) ?><br>
        <strong>ISBN:</strong> <?= Html::encode($book->isbn) ?><br>
        <strong>Фото:</strong> <?= Html::img($book->photo, ['alt' => 'Фото книги', 'class' => 'img-responsive']) ?><br>
        <strong>Авторы:</strong> <?= Html::encode(implode(', ', array_map(fn($author) => $author->full_name, $book->authors))) ?: 'Неизвестно' ?>
    </p>

    <p>
        <?= Html::a('Редактировать', ['update', 'id' => $book->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Назад к списку', ['index'], ['class' => 'btn btn-default']) ?>
    </p>
</div>