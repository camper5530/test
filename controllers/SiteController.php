<?php

namespace app\controllers;

use Yii;
use app\models\Tag;
use app\models\Movie;
use app\models\MovieTags;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\helpers\ArrayHelper;

class SiteController extends Controller
{
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }
    /*******************************************************************************************************
     * Метод для главной страницы.
     * Выборка полного списка тегов с фильмами посредством промежуточной таблицы (классический вариант).
     * Выборку можно осуществить и с помощью Join'ов, но было решено использовать стандартные средства фреймворка.
    ********************************************************************************************************/
    public function actionIndex()
    {
        $list = Tag::find()->asArray()->orderBy(['title' => SORT_ASC])->with('movie','movie.tags')->all();
        return $this->render('index', compact('list'));
    }
    /*******************************************************************************************************
     * Метод для страницы добавления фильма.
     * Формируется список тегов, из которых можно выбрать нужные. Также в виде есть поле для ввода нового тега.
     * Посредством асинсхронной передачи данных добавлять можно неограниченное количество тегов. Если пользователь отключит JS,
     * тогда добавление новых тегов ограничится лишь одним элементом.
     * При получении формы происходит проверка, выбраны ли теги и/или введен новый. В случае наличия таковых данных сохраняется сам фильм, затем новый тег
     * (ajax сохраняет налету новый тег). Потом следует сохранение полученных связей в промежуточной таблице.
     * В противном случае, страница перезагружается и пользователю приходит уведомление об ошибке.
     ********************************************************************************************************/
    public function actionCreate()
    {
        $movie = new Movie();
        $data = Tag::find()->asArray()->orderBy('title')->all();
        $movie->list = ArrayHelper::map($data,'id','title');
        if ($movie->load( Yii::$app->request->post()) ) {
            if(empty($movie->tags) && !trim($movie->new)){
                Yii::$app->session->setFlash('error', 'Теги не выбраны!');
                return $this->refresh();
            }
            if($movie->save()){
                $movie_id = $movie->id;
                if(!empty($movie->tags)){
                    foreach ($movie->tags as $tag_id) {
                        $this->saveMovieTag($movie_id, $tag_id);
                    }
                }
                if($movie->new){
                    $new = title($movie->new);
                    if(!in_array(($new),$movie->list)){
                        $tag = new Tag();
                        $tag->title = $new;
                        $tag->save();
                        $this->saveMovieTag($movie_id,$tag->id);
                    }else{
                        $key = array_search($new, $movie->list);
                        $this->saveMovieTag($movie_id,$key);
                    }
                }
                Yii::$app->session->setFlash('success', 'Запись успешно сохранена!');
                return $this->redirect(['/']);
            }
        }
        return $this->render('create',compact('movie'));
    }
    /*******************************************************************************************************
     * Метод для страницы редактирования фильма.
     * Принцип работы метода практически идентичен с предыдущим. Разница в том, что дополнительно получаем данные о фильмы из бд, включая
     * уже существующие связи (теги).
     * А при сохранении сначала удаляются все связи фильма из промежуточной таблицы, затем сохраняются новые.
     ********************************************************************************************************/
    public function actionUpdate($id)
    {
        $movie = $this->findMovie($id);
        $data = Tag::find()->asArray()->orderBy('title')->all();
        $movie->list = ArrayHelper::map($data,'id','title');
        $data = MovieTags::find()->where(['movie_id' => $id])->asArray()->all();
        $movie->tags =ArrayHelper::getColumn($data, 'tag_id');
        if ( $movie->load( Yii::$app->request->post() ) ) {
            if(empty($movie->tags) && !$movie->new){
                Yii::$app->session->setFlash('error', 'Теги не выбраны!');
                return $this->refresh();
            }
            if($movie->save()){
                $old_tags = MovieTags::find()->where(['movie_id' => $id])->all();
                foreach($old_tags as $item){
                    $item->delete();
                }
                if(!empty($movie->tags)) {
                    foreach ($movie->tags as $tag_id) {
                        $this->saveMovieTag($id, $tag_id);
                    }
                }
                if($movie->new){
                    $new = title($movie->new);
                    if(!in_array(($new),$movie->list)){
                        $tag = new Tag();
                        $tag->title = $new;
                        $tag->save();
                        $this->saveMovieTag($id,$tag->id);
                    }else{
                        $key = array_search($new, $movie->list);
                        $this->saveMovieTag($id,$key);
                    }
                }
                Yii::$app->session->setFlash('success', 'Запись успешно сохранена!');
                return $this->redirect(['/']);
            }
        }
        return $this->render('update',compact('movie'));
    }
    /*******************************************************************************************************
     * Метод для удаления тега фильма на главной странице.
     * В целом, стандартный метод, сформированный с помощью генеротора кода фреймворка.
     * Находится id связи из промежуточной таблицы и удаляется.
     ********************************************************************************************************/
    public function actionDelete($id)
    {
        $this->findMovieTag($id)->delete();
        return $this->redirect(['/']);
    }
    /*******************************************************************************************************
     * Метод для добавления новых тегов посредством асинхронной передачи данных.
     * Проверяется наличие списка существующий тегов, которые сохраняются в сессии при первом обращении к скрипту.
     * Если элемент присутствует в массиве, тогда вернется его id, чекбокс станет активным.
     * В противном случае в бд сохраняется новый тег, добавляется в существующий массив сессии, а также в виде формируется новый тег.
     ********************************************************************************************************/
    public function actionAdd()
    {
        $title = trim(Yii::$app->request->post('title'));
        if(!$title || !Yii::$app->request->isAjax) return false;
        $session = Yii::$app->session;
        $session->open();
        if(!isset($_SESSION['tags'])){
            $tags = Tag::find()->asArray()->all();
            $tags = ArrayHelper::map($tags,'id','title');
            $_SESSION['tags'] = $tags;
        }
        $title = title($title);
        if(!in_array(($title),$_SESSION['tags'])){
            $tag = new Tag();
            $tag->title = $title;
            $tag->save();
            $_SESSION['tags'][$tag->id] = $title;
            return $this->renderAjax('_add', compact('tag'));
        }else{
            $key = array_search($title, $_SESSION['tags']);
            return $key;
        }
    }
    /*******************************************************************************************************
     * Метод для 2 задания.
     * Формируем два массива: количество матриц и элементы матрицы.
     * Дальнейшие операции производятся в виде. Стандартные методы: перебор массива с использованием счетчика.
     ********************************************************************************************************/
    public function actionMatrix()
    {
        $count = range(1,30);
        $matrix = range(1,9);
        return $this->render('matrix', compact('count', 'matrix'));
    }

    /*******************************************************************************************************
     * Три вспомогательных метода обработки данных, не представляют особого интереса
     ********************************************************************************************************/
    protected function findMovie($id)
    {
        if (($model = Movie::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('Страница не найдена.');
        }
    }
    protected function findMovieTag($id)
    {
        if (($model = MovieTags::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('Страница не найдена.');
        }
    }
    protected function saveMovieTag($movie_id, $tag_id)
    {
        $movie_tag = new MovieTags();
        $movie_tag->movie_id = $movie_id;
        $movie_tag->tag_id = $tag_id;
        $movie_tag->save();
    }

}
