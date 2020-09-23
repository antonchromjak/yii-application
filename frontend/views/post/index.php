<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\LinkPager;
use common\models\User;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'My Posts';
$this->params['breadcrumbs'][] = $this->title;



?>
<div class="post-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Post', ['create'], ['class' => 'btn btn-success']) ?>
    </p>


<ul>
<?php /*
echo '<pre>';
  var_dump($posts);
echo '</pre>';
exit;*/
?>


<?php foreach ($posts as $post): ?>
    <li>
        <div class="photo">
            <?= Html::img("@web/storage/photos/{$post['id']}.jpg") ?>
        </div>
        <div class="text">
          <h2><?= Html::encode("{$post['title']}") ?></h2>
          <p><?= $post->publishedAt ?> Posted <?= Html::encode("{$post['publishedAt']}") ?> by 
          <?= Html::a(Html::encode("{$post['username']}"), ['user/view', 'id' => $post['userId']], ['class' => 'post-link user']) ?>
          
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
          <?= Html::a( 'delete', 
                      ['post/delete', 'id' => $post['id']], 
                      ['class' => 'post-link delete','data-method' => 'POST']) ?>
          <?= Html::a('update', ['post/update', 'id' => $post['id']], ['class' => 'post-link update']) ?>
        </div>
        <div class="clear"></div>
    </li>
<?php endforeach; ?>
</ul>

<?= LinkPager::widget(['pagination' => $pagination]) ?>

</div>
