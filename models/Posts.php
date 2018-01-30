<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "posts".
 *
 * @property int $id
 * @property int $user_id
 * @property string $title
 * @property string $body
 * @property string $type
 * @property string $post_on
 * @property string $ref
 *
 * @property Comments[] $comments
 * @property User $user
 */
class Posts extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'posts';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'body', 'type'], 'required'],
            [['user_id'], 'integer'],
            [['body', 'type'], 'string'],
            [['post_on'], 'safe'],
            [['title'], 'string', 'max' => 256],
            [['ref'], 'string', 'max' => 32],
            [['ref'], 'unique'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'title' => 'Title',
            'body' => 'Body',
            'type' => 'Type',
            'post_on' => 'Post On',
            'ref' => 'Ref',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComments()
    {
        return $this->hasMany(Comments::className(), ['post_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
    
    public function beforeSave($insert)
    {
    if (parent::beforeSave($insert)) {
            $this->user_id = Yii::$app->user->identity->id;
            $this->post_on = new \yii\db\Expression('NOW()');
            $this->ref = substr(md5(date('y-m-d H:i:s'). rand(0, 100000)),-8);
            return true;
        } else {
            return false;
        }
    } 
}
