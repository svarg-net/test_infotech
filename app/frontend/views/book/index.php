<?php
use yii\widgets\LinkPager;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $books common\models\Book[] */
/* @var $pagination yii\data\Pagination */

$this->title = 'Список книг';
$this->params['breadcrumbs'][] = $this->title;
?>

<h1><?= Html::encode($this->title) ?></h1>

<!-- Кнопка для добавления новой книги -->
<p>
    <?= Html::a('Добавить книгу', ['book/create'], ['class' => 'btn btn-success']) ?>
</p>

<table class="table table-bordered">
    <thead>
    <tr>
        <th>ID</th>
        <th>Название</th>
        <th>Авторы</th>
        <th>Год публикации</th>
        <th>Действия</th> <!-- Колонка для действий -->
    </tr>
    </thead>
    <tbody>
    <?php if (!empty($books)): ?>
        <?php foreach ($books as $book): ?>
            <tr>
                <td><?= Html::encode($book->id) ?></td>
                <td><?= Html::encode($book->title) ?></td>
                <td>
                    <?= Html::encode(implode(', ', array_map(fn($author) => $author->full_name, $book->authors))) ?: 'Неизвестно' ?>
                </td>
                <td><?= Html::encode($book->year) ?></td>
                <td>
                    <?= Html::a('Просмотреть', ['book/view', 'id' => $book->id], ['class' => 'btn btn-info']) ?> <!-- Кнопка просмотра -->
                    <?php if (Yii::$app->user->can('updateBook', ['book' => $book])): ?>
                        <?= Html::a('Редактировать', ['book/update', 'id' => $book->id], ['class' => 'btn btn-primary']) ?>
                    <?php endif; ?>
                    <?php if (Yii::$app->user->can('deleteBook', ['book' => $book])): ?>
                        <?= Html::a('Удалить', ['book/delete', 'id' => $book->id], [
                            'class' => 'btn btn-danger',
                            'data' => [
                                'confirm' => 'Вы уверены, что хотите удалить эту книгу?',
                                'method' => 'post',
                            ],
                        ]) ?>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
    <?php else: ?>
        <tr>
            <td colspan="5" class="text-center">Нет доступных книг.</td>
        </tr>
    <?php endif; ?>
    </tbody>
</table>

<!-- Пагинация -->
<div class="pagination-container">
    <?= LinkPager::widget([
        'pagination' => $pagination,
    ]); ?>
</div>