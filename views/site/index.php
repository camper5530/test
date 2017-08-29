<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
$this->title = 'Фильмотека :: Тестовое задание';

?>
<div class="site-index">
    <div class="body-content">
        <?if( Yii::$app->session->hasFlash('success') ): ?>
            <div class="alert alert-success alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <?= Yii::$app->session->getFlash('success'); ?>
            </div>
        <?endif;?>

        <?if( Yii::$app->session->hasFlash('error') ): ?>
            <div class="alert alert-danger alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <?= Yii::$app->session->getFlash('error'); ?>
            </div>
        <?endif;?>
        <h1>Фильмотека</h1>
        <p>
            <?= Html::a('Добавить фильм', ['create'], ['class' => 'btn btn-success']) ?>
        </p>
        <?if(!empty($list)):?>
            <?foreach ($list as $item):?>
                <?$count = count($item['movie']);?>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4><?=$item['title'] . ' (' . $count . ')'?></h4>
                    </div>
                    <?if($count != 0):?>
                    <table class="table movie_list">
                        <thead>
                        <tr>
                            <th>Название</th>
                            <th>Год</th>
                            <th>Жанр</th>
                            <th>Операции</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?ArrayHelper::multisort($item['movie'], ['title','year'], [SORT_ASC, SORT_DESC]);?>
                        <?foreach ($item['movie'] as $movie):?>
                            <tr>
                                <td><?=$movie['title']?></td>
                                <td><?=$movie['year']?></td>
                                <td>
                                    <?$i = 0; $total = count($movie['tags']);
                                    foreach($movie['tags'] as $tag): $i++;?>
                                        <?=$tag['title'] . ($i == $total ? '' : ',');?>
                                    <?endforeach;?>
                                </td>
                                <td>
                                    <?$id = 0;
                                    foreach($movie['movieTags'] as $value):
                                        if($value['tag_id'] == $item['id']) $id = $value['id'];
                                    endforeach;?>
                                    <a href="<?= Url::to(['site/update', 'id' => $movie['id']])?>">Изменить</a> |
                                    <a href="<?= Url::to(['site/delete', 'id' => $id])?>" class="delete-button">Удалить</a>
                                </td>
                            </tr>
                        <?endforeach;?>
                        </tbody>
                    </table>
                    <?endif;?>
                </div>
            <?endforeach;?>
        <?else:?>
            <p>Библиотека пуста!</p>
        <?endif;?>
    </div>
</div>
