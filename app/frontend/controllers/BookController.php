<?php

namespace frontend\controllers;

use Yii;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\data\Pagination;
use common\models\Book;
use frontend\models\BookForm;
use common\models\Author;

class BookController extends Controller
{

    public function actionIndex()
    {
        $query = Book::find()->joinWith('authors');

        $pagination = new Pagination([
            'defaultPageSize' => 10,
            'totalCount' => $query->count(),
        ]);

        $books = $query->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();

        return $this->render('index', [
            'books' => $books,
            'pagination' => $pagination,
        ]);
    }

    public function actionView($id)
    {
        $book = Book::findOne($id);

        if ($book === null) {
            throw new NotFoundHttpException('Книга не найдена.');
        }

        return $this->render('view', [
            'book' => $book,
        ]);
    }

    public function actionCreate()
    {
        $model = new BookForm(); // Используем модель формы
        $authors = Author::find()->select(['full_name', 'id'])->indexBy('id')->column();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $book = new Book();
            $book->title = $model->title;
            $book->year = $model->year;
            $book->description = $model->description;
            $book->isbn = $model->isbn;
            $book->photo = $model->photo;

            if ($book->save()) {
                // Сохраняем связь с авторами
                $authorIds = $model->author_ids;
                if (!empty($authorIds)) {
                    foreach ($authorIds as $authorId) {
                        $book->link('authors', Author::findOne($authorId));
                    }
                }
                return $this->redirect(['view', 'id' => $book->id]);
            }
        }

        return $this->render('create', [
            'model' => $model, // Передаем модель формы в представление
            'authors' => $authors,
        ]);
    }

    public function actionUpdate($id)
    {
        $book = Book::findOne($id);
        if ($book === null) {
            throw new NotFoundHttpException('Книга не найдена.');
        }

        $model = new BookForm();
        $model->title = $book->title;
        $model->year = $book->year;
        $model->description = $book->description;
        $model->isbn = $book->isbn;
        $model->photo = $book->photo;
        $model->author_ids = ArrayHelper::getColumn($book->authors ?? [], 'id'); // Получаем идентификаторы авторов

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $book->title = $model->title;
            $book->year = $model->year;
            $book->description = $model->description;
            $book->isbn = $model->isbn;
            $book->photo = $model->photo;

            if ($book->save()) {
                // Обновляем связь с авторами
                $book->unlinkAll('authors', true); // Удаляем старые связи
                foreach ($model->author_ids as $authorId) {
                    $book->link('authors', Author::findOne($authorId));
                }
                return $this->redirect(['view', 'id' => $book->id]);
            }
        }
        $authors = Author::find()->select(['full_name', 'id'])->indexBy('id')->column();
        return $this->render('update', [
            'model' => $model, // Передаем модель формы в представление
            'book' => $book,
            'authors' => $authors,
        ]);
    }

    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        return $this->redirect(['index']);
    }

    protected function findModel($id)
    {
        if (($model = Book::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
