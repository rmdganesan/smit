<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;

class SiteController extends Controller {

    /**
     * @inheritdoc
     */
    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions() {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex($id = null) {
        if (!empty($_GET)) {
            $id = array_keys($_GET);
            $id = $id[0];
            $model = new \app\models\Comments();
            if (!empty($_POST)) {
                if ($model->load(Yii::$app->request->post()) && $model->save()) {
                    //return $this->redirect(['view', 'id' => $model->id]);
                }
            }
            $post = \app\models\Posts::find()->where(['ref' => $id])->one();
            $comment = \app\models\Comments::find()->where(['post_id' => !empty($post->id) ? $post->id : 0])
                            ->orderBy(['comment_on' => SORT_DESC])->all();
            return $this->render('review', [
                        'post' => $post, 'comment' => $comment, 'model' => $model
            ]);
        }
        /* get posts */
        if (Yii::$app->user->isGuest) {
            $model = \app\models\Posts::find()->where(['type' => 'public'])
                            ->orderBy(['post_on' => SORT_DESC])->all();
        } else {
            $model = \app\models\Posts::find()->where(['type' => 'public'])
                            ->orWhere(['user_id' => Yii::$app->user->identity->id])
                            ->orderBy(['post_on' => SORT_DESC])->all();
        }

        return $this->render('index', [
                    'model' => $model,
        ]);
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin() {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
                    'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout() {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact() {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
                    'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout() {
        return $this->render('about');
    }

}
