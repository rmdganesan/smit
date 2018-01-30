<?php

/* @var $this yii\web\View */

$this->title = 'My Yii Application';

?>
<div class="site-index">
 <?PHP if(empty($post)) { ?>
    <div class="jumbotron">
        <h3>Invalid reference!</h3>

        <p class="lead">Please check the input.</p>

        <p><a class="btn btn-lg btn-success" href="/">Go Back To Home...</a></p>
    </div>
 <?PHP } else { ?>
  

    <div class="body-content">

        <div class="row">
            <div class="col-lg-12">
                <h2>Public Pastes <?PHP echo $post->title ?></h2>
                
                <div class="table-responsive">
                    <span><p><?PHP echo $post->body ?></p></span>
                    <hr />
                    <h2>Posts conversations</h2>
                    <?PHP foreach ($comment as $data) {  ?>
                    <h4><i class="fa fa-user"></i> &nbsp; 
                        <?PHP if(empty($data->user->name)) {
                            echo 'Anonymous User';
                            }else {
                                echo ucfirst($data->user->name);
                            }
                            ?> 
                        &nbsp;&nbsp;&nbsp;<i class="fa fa-clock-o"></i>  <?= \yii\timeago\TimeAgo::widget(['timestamp' => $data->comment_on]); ?></h4>
                    
                    <span><p><?PHP echo $data->comment ?></p></span>
                     <hr />
                    <?PHP } ?>
          </div>
                
               <div class="posts-create">

    <h1>New Comment</h1>

    <?= $this->render('_form', [
        'model' => $model, 'post' => $post
    ]) ?>

</div>

                            </div>
            
            
        </div>

    </div>
 <?PHP } ?>
</div>
