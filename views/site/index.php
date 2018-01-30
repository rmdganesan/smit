<?php

/* @var $this yii\web\View */

$this->title = 'My Yii Application';

?>
<div class="site-index">

    <div class="jumbotron">
        <h1>Congratulations!</h1>

        <p class="lead">Welcome to SMIT Demo Project.</p>

        <p><a class="btn btn-lg btn-success" href="/posts/create">Create new post</a></p>
    </div>
    
  

    <div class="body-content">

        <div class="row">
            <div class="col-lg-12">
                <h2>Public Pastes <?PHP if(!Yii::$app->user->isGuest) { echo ' & your Private Pastes'; } ?></h2>
                
                <div class="table-responsive">
            <table class="table">
              <tbody>
                  <?PHP foreach ($model as $data) { ?>
                  <tr>
                      <th style="width:80%"><a href="?<?PHP echo $data->ref; ?>"> <?PHP echo $data->title; ?> </a></th>
                      <td> <span class="time"><i class="fa fa-clock-o"></i> &nbsp;<?= \yii\timeago\TimeAgo::widget(['timestamp' => $data->post_on]); ?></span> </td>
              </tr>
                  <?PHP               }  ?>
 
            </tbody></table>
          </div>
                
               

                            </div>
            
            
        </div>

    </div>
</div>
