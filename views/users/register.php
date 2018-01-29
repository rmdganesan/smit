<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">
   
    <p>Please fill out the following fields for setup new account</p>

  <?= $this->render('_form', [
        'model' => $model,
    ]) ?>


</div>
