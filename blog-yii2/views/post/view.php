<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Post */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Posts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="post-view">

    <div class="d-flex justify-content-between align-items-start mb-4">
        <div>
            <h1><?= Html::encode($this->title) ?></h1>
            <p class="text-muted">
                By <?= Html::encode($model->getAuthorName()) ?> 
                on <?= Yii::$app->formatter->asDatetime($model->date) ?>
            </p>
        </div>
        <div>
            <?php 
            $user = Yii::$app->user->identity;
            $canEdit = $user && ($user->isAdmin() || ($user->isAuthor() && $model->username === $user->username));
            ?>
            <?php if ($canEdit): ?>
                <?= Html::a('Update', ['update', 'id' => $model->idpost], ['class' => 'btn btn-primary']) ?>
                <?= Html::a('Delete', ['delete', 'id' => $model->idpost], [
                    'class' => 'btn btn-danger',
                    'data' => [
                        'confirm' => 'Are you sure you want to delete this item?',
                        'method' => 'post',
                    ],
                ]) ?>
            <?php endif; ?>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="post-content">
                <?= nl2br(Html::encode($model->content)) ?>
            </div>
        </div>
    </div>

    <div class="mt-4">
        <?= Html::a('← Back to Posts', ['index'], ['class' => 'btn btn-secondary']) ?>
        <?php if (!Yii::$app->user->isGuest): ?>
            <?= Html::a('Create New Post', ['create'], ['class' => 'btn btn-success']) ?>
        <?php endif; ?>
    </div>

</div>