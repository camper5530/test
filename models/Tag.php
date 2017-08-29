<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tag".
 *
 * @property integer $id
 * @property string $title
 *
 * @property MovieTags[] $movieTags
 */
class Tag extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tag';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['title'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMovieTags()
    {
        return $this->hasMany(MovieTags::className(), ['tag_id' => 'id']);
    }
    public function getMovie()
    {
        return $this->hasMany(Movie::className(), ['id' => 'movie_id'])->via('movieTags');
    }

    /*public function addToTags($tag){
        if(!isset($_SESSION['tags'][$tag->id])){
            $_SESSION['tags'][] = $tag->id;
        }
    }*/
}
