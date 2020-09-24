<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;
use yii\widgets\LinkPager;
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
          <?= Html::a(Html::encode("{$post['username']}"), ['user/view', 'id' => $post['userId']], ['class' => 'post-link user']) ?> (<?= Html::encode("{$post['about']}")?>)
          
        </p>
          <p class="perex"><?= Html::encode("{$post['perex']}") ?></p>

          <p><?= $post['content']?></p>
          
        </div>
        <div class="tags">
        <?php 
        $tags = explode(",", $post['tags']);
        if($tags[0] == '') $tags = array();
        
        foreach ($tags as $tag): ?>
          <?= Html::a(trim($tag), ['post/search', 'keyword' => trim($tag)], ['class' => 'post-link view']) ?>
        <?php endforeach; ?>
        </div>
        <div class="tool">
        
        </div>
        <div class="clear"></div>
    </li>
</ul>
<form action="<?php echo Url::to(['/comment/create']) ?>"class="">
    <input type="hidden" id="postId" name="postId" value="<?= Html::encode("{$post['id']}") ?>">
    <button class="btn btn-outline-success">Comment</button>
</form>

<ul>
<br>
<h2>Comments:</h2>
<br>
<?php foreach ($comments as $comment): ?>
    <li>
        <div class="by">
          Posted by <?= Html::a(Html::encode("{$comment['username']}"), NULL, ['class' => 'post-link user', 'title' => Html::encode("{$comment['about']}")]) ?>
        </div>
        <div class="comment">
          <?= Html::encode("{$comment['content']}") ?>
        </div>

        <div class="clear"></div>
    </li>
<?php endforeach; ?>
</ul>

<?= LinkPager::widget(['pagination' => $pagination]) ?>