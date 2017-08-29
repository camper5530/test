<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

?>
<div class="movie-form">

    <?$form = ActiveForm::begin(); ?>

    <?= $form->field($movie, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($movie, 'year')->textInput() ?>

    <label class="control-label" for="movie-new">Теги</label>
    <div class="input-group">

    <?= $form->field($movie, 'new')->textInput(['placeholder' => 'Введите название нового тега...', 'class' => 'form-control', 'autocomplete' => 'off'])->label(false)?>

        <span class="input-group-btn">
            <button id="add-tag" class="btn btn-default" type="button">
                <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
            </button>
      </span>
    </div>

    <?= $form->field($movie, 'tags')->checkboxList($movie->list, ['item'=>function ($index, $label, $name, $checked, $value){
        return Html::checkbox($name, $checked, [
            'value' => $value,
            'label' => $label,
            'id' => 'tag' . $value,
        ]);
    }])->label(false)?>

    <div class="form-group">

        <?= Html::submitButton($movie->isNewRecord ? 'Создать' : 'Сохранить', ['class' => $movie->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>

        <a href="<?=Url::to(['/'])?>" class="btn btn-default">Отмена</a>

    </div>

    <?ActiveForm::end(); ?>

</div>