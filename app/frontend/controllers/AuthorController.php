<?php

namespace frontend\controllers;

use common\models\User;
use Yii;
use yii\db\Query;
use yii\web\Controller;
use common\models\Author;
use frontend\models\AuthorForm;
use yii\web\NotFoundHttpException;

class AuthorController extends Controller
{
    public function actionIndex()
    {
        $authors = Author::find()->all();
        return $this->render('index', ['authors' => $authors]);
    }

    public function actionCreate()
    {
        $model = new AuthorForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $author = new Author();
            $author->full_name = $model->full_name;

            if ($author->save()) {
                return $this->redirect(['index']);
            }
        }
        return $this->render('create', ['model' => $model]);
    }

    public function actionUpdate($id)
    {
        $author = Author::findOne($id);
        if ($author === null) {
            throw new NotFoundHttpException('Автор не найден.');
        }

        $model = new AuthorForm();
        $model->full_name = $author->full_name;

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $author->full_name = $model->full_name;

            if ($author->save()) {
                return $this->redirect(['index']);
            }
        }

        return $this->render('update', ['model' => $model, 'author' => $author]);

    }

    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        return $this->redirect(['index']);
    }

    protected function findModel($id)
    {
        if (($model = Author::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionSubscribeToAuthor($authorId)
    {
        $userId = Yii::$app->user->id;

        // Проверяем, существует ли пользователь
        $user = User::findOne($userId);
        if (!$user) {
            throw new NotFoundHttpException('Пользователь не найден.');
        }

        // Проверяем, существует ли автор
        $author = Author::findOne($authorId);
        if (!$author) {
            throw new NotFoundHttpException('Автор не найден.');
        }
        $existingSubscription = (new \yii\db\Query())
            ->from('user_author_subscription')
            ->where(['user_id' => $userId, 'author_id' => $authorId])
            ->exists();
        if ($existingSubscription) {
            Yii::$app->session->setFlash('error', 'Вы уже подписаны на этого автора.');
        } else {
            $user->link('subscriptions', $author);
            Yii::$app->session->setFlash('success', 'Вы успешно подписались на автора.');
        }

        return $this->redirect(['index']);
    }
}