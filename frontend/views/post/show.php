<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\LinkPager;
use common\models\User;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Posts';
$this->params['breadcrumbs'][] = $this->title;



?>
<div class="post-index">

    <h1><?= Html::encode($this->title) ?></h1>

<ul>

<?php foreach ($posts as $post): ?>
    <li>
        <div class="photo">
            <?= Html::img("@web/storage/photos/{$post['id']}.jpg") ?>
        </div>
        <div class="text">
          <h2><?= Html::encode("{$post['title']}") ?></h2>
          <p><?= $post->publishedAt ?> Posted <?= Html::encode("{$post['publishedAt']}") ?> by 
          <?= Html::a(Html::encode("{$post['username']}"), ['user/view', 'id' => $post['userId']], ['class' => 'post-link user', 'title' => Html::encode("{$post['about']}")]) ?>
          
        </p>
          <p><?= Html::encode("{$post['perex']}") ?></p>
          
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
        <?= Html::a('view', ['post/view', 'id' => $post['id']], ['class' => 'post-link view']) ?>
        </div>
        <div class="clear"></div>
    </li>
<?php endforeach; ?>
</ul>

<?= LinkPager::widget(['pagination' => $pagination]) ?>

</div>
