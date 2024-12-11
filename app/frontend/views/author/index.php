<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $authors common\models\Author[] */

$this->title = 'Авторы';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="author-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Создать автора', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <table class="table table-striped">
        <thead>
        <tr>
            <th>ID</th>
            <th>ФИО</th>
            <th>Действия</th>
        </tr>
        </thead>
        <tbody>
        <?php if (!empty($authors)): ?>
            <?php foreach ($authors as $author): ?>
                <tr>
                    <td><?= Html::encode($author->id) ?></td>
                    <td><?= Html::encode($author->full_name) ?></td>
                    <td>
                        <?= Html::a('Просмотр', ['view', 'id' => $author->id], ['class' => 'btn btn-primary']) ?>
                        <?= Html::a('Обновить', ['update', 'id' => $author->id], ['class' => 'btn btn-warning']) ?>
                        <?= Html::a('Удалить', ['delete', 'id' => $author->id], [
                            'class' => 'btn btn-danger',
                            'data' => [
                                'confirm' => 'Вы уверены, что хотите удалить этот элемент?',
                                'method' => 'post',
                            ],
                        ]) ?>
                        <?= \yii\helpers\Html::a('Подписаться на автора', ['author/subscribe-to-author', 'authorId' => $author->id], ['class' => 'btn btn-primary']) ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="3">Нет авторов для отображения.</td>
            </tr>
        <?php endif; ?>
        </tbody>
    </table>

</div>