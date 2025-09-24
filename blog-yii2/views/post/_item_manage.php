<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Post */

?>
<div class="card">
    <div class="card-body">
        <h5 class="card-title"><?= Html::a(Html::encode($model->title), ['/post/view', 'id' => $model->idpost]) ?></h5>
        <p class="card-text"><?= $model->getContentPreview(150) ?></p>
        <div class="d-flex justify-content-between align-items-center">
            <small class="text-muted">
                By <?= Html::encode($model->getAuthorName()) ?> 
                on <?= Yii::$app->formatter->asDatetime($model->date) ?>
            </small>
            <div>
                <?= Html::a('View', ['/post/view', 'id' => $model->idpost], ['class' => 'btn btn-outline-primary btn-sm']) ?>
                <?php 
                $user = Yii::$app->user->identity;
                $canEdit = $user && ($user->isAdmin() || ($user->isAuthor() && $model->username === $user->username));
                ?>
                <?php if ($canEdit): ?>
                    <?= Html::a('Edit', ['/post/update', 'id' => $model->idpost], ['class' => 'btn btn-warning btn-sm']) ?>
                    <?= Html::a('Delete', ['/post/delete', 'id' => $model->idpost], [
                        'class' => 'btn btn-danger btn-sm',
                        'data' => [
                            'confirm' => 'Are you sure you want to delete this post?',
                            'method' => 'post',
                        ],
                    ]) ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>