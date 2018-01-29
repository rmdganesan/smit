<?php

namespace app\common\models;

use Yii;

/**
 * This is the model class for table "users".
 *
 * @property integer $id
 * @property integer $clientid
 * @property string $stripeId
 * @property integer $default_Group
 * @property integer $default_Location
 * @property string $type
 * @property string $displayname
 * @property string $firstname
 * @property string $lastname
 * @property string $companyname
 * @property double $nXBalance
 * @property string $email
 * @property string $image
 * @property string $dob
 * @property string $corpuser
 * @property string $createddate
 * @property string $updateddate
 * @property string $status
 * @property string $cardnumber
 * @property integer $default_template
 * @property integer $default_address
 */
class Users extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'users';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['clientid', 'default_Group', 'default_Location', 'displayname', 'firstname', 'lastname', 'email', 'dob', 'createddate', 'cardnumber', 'default_template', 'default_address'], 'required'],
            [['clientid', 'default_Group', 'default_Location', 'default_template', 'default_address'], 'integer'],
            [['type', 'image', 'corpuser', 'status'], 'string'],
            [['nXBalance'], 'number'],
            [['dob', 'createddate', 'updateddate'], 'safe'],
            [['stripeId', 'displayname', 'firstname', 'lastname', 'companyname', 'email'], 'string', 'max' => 255],
            [['cardnumber'], 'string', 'max' => 100],
            [['image'], 'file', 'extensions' => 'jpg,png,gif'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'clientid' => Yii::t('app', 'Clientid'),
            'stripeId' => Yii::t('app', 'Stripe ID'),
            'default_Group' => Yii::t('app', 'Default  Group'),
            'default_Location' => Yii::t('app', 'Default  Location'),
            'type' => Yii::t('app', 'Type'),
            'displayname' => Yii::t('app', 'Displayname'),
            'firstname' => Yii::t('app', 'Firstname'),
            'lastname' => Yii::t('app', 'Lastname'),
            'companyname' => Yii::t('app', 'Companyname'),
            'nXBalance' => Yii::t('app', 'N Xbalance'),
            'email' => Yii::t('app', 'Email'),
            'image' => Yii::t('app', 'Image'),
            'dob' => Yii::t('app', 'Dob'),
            'corpuser' => Yii::t('app', 'Corpuser'),
            'createddate' => Yii::t('app', 'Createddate'),
            'updateddate' => Yii::t('app', 'Updateddate'),
            'status' => Yii::t('app', 'Status'),
            'cardnumber' => Yii::t('app', 'Cardnumber'),
            'default_template' => Yii::t('app', 'Default Template'),
            'default_address' => Yii::t('app', 'Default Address'),
        ];
    }

    
    }
