<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\AuthorForm */
/* @var $author common\models\Author */

$this->title = 'Обновить автора: ' . $author->full_name;
$this->params['breadcrumbs'][] = ['label' => 'Авторы', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $author->full_name, 'url' => ['view', 'id' => $author->id]];
$this->params['breadcrumbs'][] = 'Обновить';
?>

<div class="author-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="author-form">

        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'full_name')->textInput(['maxlength' => true]) ?>

        <div class="form-group">
            <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
            <?= Html::a('Отмена', ['view', 'id' => $author->id], ['class' => ' btn btn-danger']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

</div>