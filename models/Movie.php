<?php

namespace app\models;

use Yii;

class Movie extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'movie';
    }

    public $list;
    public $tags;
    public $new;
    public $temp;

    public function rules()
    {
        return [
            [['title', 'year'], 'required'],
            [['year'], 'integer' ,'max' => 2155, 'min' => 1901],
            [['tags'], 'safe'],
            [['new','title'], 'string', 'max' => 255],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Название',
            'year' => 'Год',
        ];
    }

    public function getMovieTags()
    {
        return $this->hasMany(MovieTags::className(), ['movie_id' => 'id']);
    }
    public function getTags()
    {
        return $this->hasMany(Tag::className(), ['id' => 'tag_id'])->via('movieTags');
    }

}
