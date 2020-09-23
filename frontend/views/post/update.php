<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use coderius\pell\Pell;
/* @var $this yii\web\View */
/* @var $model common\models\Post */

\frontend\assets\TagsInputAsset::register($this);

$this->title = 'Update Post: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Posts', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="post-update">

    <h1><?= Html::encode($this->title) ?></h1>


    <div class="post-form">

<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>

<?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

<?= $form->field($model, 'perex')->textarea(['rows' => 3]) ?>



<?= $form->field($model, 'content')->widget(Pell::className(), []);?>

<?= $form->field($model, 'tags', ['inputOptions' => ['data-role' => 'tagsinput']])->textInput(['maxlength' => true]) ?>

<?= $form->field($model, 'photo')->fileInput() ?>

<div class="form-group">
    <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
</div>

<?php ActiveForm::end(); ?>

</div>
</div>
