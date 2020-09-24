<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\LinkPager;
use common\models\User;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Posts';
$this->params['breadcrumbs'][] = $this->title;



?>
<div class="post-index">

    <h1><?= Html::encode($this->title) ?></h1>

<ul>
<form action="<?php echo Url::to(['/post/search']) ?>"
        class="form-inline my-2 my-lg-0">
    <input class="form-control mr-sm-2" type="search" placeholder="Search"
        name="keyword"
        value="<?php echo Yii::$app->request->get('keyword') ?>">
    <button class="btn btn-outline-success my-2 my-sm-0">Search</button>
</form>
<?php foreach ($posts as $post): ?>
    <li>
        <div class="photo">
            <?= Html::img("@web/storage/photos/{$post['id']}.jpg") ?>
        </div>
        <div class="text">
          <h2><?= Html::encode("{$post['title']}") ?></h2>
          <p><?= $post->publishedAt ?> Posted <?= Html::encode("{$post['publishedAt']}") ?> by 
          <?= Html::a(Html::encode("{$post['username']}"), NULL, ['class' => 'post-link user', 'title' => Html::encode("{$post['about']}")]) ?>
          
        </p>
          <p><?= Html::encode("{$post['perex']}") ?></p>
          
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
        <?= Html::a('view', ['post/view', 'id' => $post['id']], ['class' => 'post-link view']) ?>
        </div>
        <div class="clear"></div>
    </li>
<?php endforeach; ?>
</ul>

<?= LinkPager::widget(['pagination' => $pagination]) ?>

</div>
