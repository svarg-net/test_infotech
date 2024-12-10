<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\BookForm */
/* @var $book common\models\Book */
/* @var $authors array */

$this->title = 'Обновить книгу: ' . $book->title;
$this->params['breadcrumbs'][] = ['label' => 'Книги', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $book->title, 'url' => ['view', 'id' => $book->id]];
$this->params['breadcrumbs'][] = 'Обновить';
?>

<div class="book-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="book-form">

        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'year')->textInput() ?>

        <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

        <?= $form->field($model, 'isbn')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'photo')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'author_ids')->checkboxList($authors) ?>

        <div class="form-group">
            <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
            <?= Html::a('Отмена', ['view', 'id' => $book->id], ['class' => 'btn btn-danger']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

</div>