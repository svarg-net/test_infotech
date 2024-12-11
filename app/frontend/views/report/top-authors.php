<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $topAuthors common\models\Author[] */

$this->title = 'Лучшие авторы';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="report-top-authors">

    <h1><?= Html::encode($this->title) ?></h1>

    <table class="table table-striped">
        <thead>
        <tr>
            <th>ID</th>
            <th>Имя автора</th>
            <th>Количество книг</th>
        </tr>
        </thead>
        <tbody>
        <?php if (!empty($topAuthors)): ?>
            <?php foreach ($topAuthors as $author): ?>
                <tr>
                    <td><?= Html::encode($author['id']) ?></td>
                    <td><?= Html::encode($author['full_name']) ?></td>
                    <td><?= Html::encode($author['book_count'] ?? 0) ?></td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="3">Нет данных для отображения.</td>
            </tr>
        <?php endif; ?>
        </tbody>
    </table>

</div>