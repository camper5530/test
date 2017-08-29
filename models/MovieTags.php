<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "movie_tags".
 *
 * @property integer $id
 * @property integer $movie_id
 * @property integer $tag_id
 *
 * @property Movie $movie
 * @property Tag $tag
 */
class MovieTags extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'movie_tags';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['movie_id', 'tag_id'], 'integer'],
            [['movie_id'], 'exist', 'skipOnError' => true, 'targetClass' => Movie::className(), 'targetAttribute' => ['movie_id' => 'id']],
            [['tag_id'], 'exist', 'skipOnError' => true, 'targetClass' => Tag::className(), 'targetAttribute' => ['tag_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'movie_id' => 'Movie ID',
            'tag_id' => 'Tag ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMovie()
    {
        return $this->hasMany(Movie::className(), ['id' => 'movie_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTag()
    {
        return $this->hasMany(Tag::className(), ['id' => 'tag_id']);
    }
}
