<?php

namespace api\modules\v1\controllers;
use app\models\User;


//Segurança
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\HttpBasicAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\auth\QueryParamAuth;

//Rest api
use yii\rest\ActiveController;





class UsersController extends ActiveController
{
    public $status = FALSE;
    public $message = '';
    public $id = null;
    public function init()
    {
        parent::init();
        \Yii::$app->user->enableSession = false;
    }
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => CompositeAuth::className(),
            'authMethods' => [
                HttpBasicAuth::className(),
                HttpBearerAuth::className(),
                QueryParamAuth::className(),
            ],
        ];
        return $behaviors;
    }

    public function actionLogin() {
        if (!!empty($_POST['username']) && !empty($_POST['password'])) {
            $userData = User::find()->where(['username' => $_POST['username']])->asArray()->one();
            if ($userData->username == $_POST['username'] && $userData->password == md5($_POST['password'])) {
                $userData->authKey =  md5(date('Y-m-d H:i:s').rand(1000, 10000000));
                $userData->token_update_on = date('Y-m-d H:i:s');
                $userData->save();
                $this->status = true;
                $this->message = 'success';
            }
        }
        if ($this->status != true) {
            $this->message = 'invalid request';
        }
        return array('status' => $this->status, 'message' => $this->message, 'authkey' => !empty($userData->authKey) ? $userData->authKey : '');
    }
   
    public function actionRegister() {
        $model = new User();
        $postData['User'] =  Yii::$app->request->post();
        $postData['User']['password'] = md5(date('Y-m-d H:i:s').rand(1000, 10000000));
        $postData['User']['authKey'] = md5(date('Y-m-d H:i:s').rand(1000, 10000000));
        $postData['User']['token_update_on'] = date('Y-m-d H:i:s');
        if ($model->load($postData) && $model->save()) {
             $this->status = true;
             $this->message = 'success';
             $this->id = $model->id;
        }else {
            $this->status = FALSE;
            $this->message = 'check the input';
            
        }
        return array('status' => $this->status, 'message' => $this->message, 'id' => $this->id);
    }
    public function actionIndex($auth_token){
        $users = [];
        if(!empty($auth_token)) {
            /* check the auth token is match and it's create less then 10 min */
            $userData = User::find()->where(['authKey' => $auth_token])
                    ->andWhere(['>=',['token_update_on' => 'NOW() - INTERVAL 10 MINUTE']])
                    ->asArray()->one();
            if(!empty($userData)) {
                $users = User::findAll();
                $this->status = true;
                $this->message = 'success';
            }else {
                $this->status = FALSE;
            $this->message = 'invalid auth token';
            }
 
        }else {
            $this->status = FALSE;
            $this->message = 'auth token is empty';
        }
        return array('status' => $this->status, 'message' => $this->message, 'users' => $users);
    }
    public function actionLogoutOtherSessions($id) {
        if(!empty($id)) {
            /* check the auth token is match and it's create less then 10 min */
            $userData = User::find()->where(['id' => $id])
                    ->asArray()->one();
            if(!empty($userData)) {
                /* unset auth token */
                $users = User::findOne($id);
                $users->authKey = '';
                $users->save(FALSE);
                $this->status = true;
                $this->message = 'success';
            }else {
                $this->status = FALSE;
            $this->message = 'invalid user id';
            }
 
        }else {
            $this->status = FALSE;
            $this->message = 'user id is empty';
        }
        return array('status' => $this->status, 'message' => $this->message);
        
    }
    
    
}


