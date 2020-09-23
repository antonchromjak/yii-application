<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Post */

$this->title = $post['title'];
$this->params['breadcrumbs'][] = ['label' => 'Posts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>

<div class="post-index">

    <h1><?= Html::encode($this->title) ?></h1>

<ul>
    <li>
        <div class="photo">
            <?= Html::img("@web/storage/photos/{$post['id']}.jpg") ?>
        </div>
        <div class="text">
          <p><?= $post->publishedAt ?> Posted <?= Html::encode("{$post['publishedAt']}") ?> by 
          <?= Html::a(Html::encode("{$post['username']}"), ['user/view', 'id' => $post['userId']], ['class' => 'post-link user']) ?>
          
        </p>
          <p class="perex"><?= Html::encode("{$post['perex']}") ?></p>

          <p><?= $post['content']?></p>
          
        </div>
        <div class="tags">
        <?php 
        $tags = explode(",", $post['tags']);
        if($tags[0] == '') $tags = array();
        
        foreach ($tags as $tag): ?>
          <?= Html::a(trim($tag), ['post/tag', 'id' => trim($tag)], ['class' => 'post-link view']) ?>
        <?php endforeach; ?>
        </div>
        <div class="tool">
        
        </div>
        <div class="clear"></div>
    </li>
</ul>