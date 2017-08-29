<?php

use yii\helpers\Html;

$this->title = 'Редактирование записи';
$this->params['breadcrumbs'][] = 'Новая запись';
?>
<div class="movie-create">

    <?if( Yii::$app->session->hasFlash('error') ): ?>
        <div class="alert alert-danger alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <?= Yii::$app->session->getFlash('error'); ?>
        </div>
    <?endif;?>

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', compact('movie'))?>

</div>
