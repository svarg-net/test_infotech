<?php
namespace frontend\controllers;

use yii\web\Controller;
use common\models\Author;

class ReportController extends Controller
{
    public function actionTopAuthors()
    {
        $topAuthors = Author::find()
            ->select(['authors.id', 'authors.full_name', 'COUNT(books.id) AS book_count'])
            ->joinWith('books')
            ->groupBy('authors.id')
            ->orderBy(['book_count' => SORT_DESC])
            ->limit(10)
            ->asArray()
            ->all();
        return $this->render('top-authors', ['topAuthors' => $topAuthors]);
    }
}