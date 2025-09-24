<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Account */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Accounts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="account-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->username], ['class' => 'btn btn-primary']) ?>
        <?php if ($model->username !== Yii::$app->user->identity->username): ?>
            <?= Html::a('Delete', ['delete', 'id' => $model->username], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Are you sure you want to delete this item?',
                    'method' => 'post',
                ],
            ]) ?>
        <?php endif; ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'username',
            'name',
            [
                'attribute' => 'role',
                'value' => function($model) {
                    return $model->role === 'admin' ? 'Administrator' : 'Author';
                },
            ],
        ],
    ]) ?>

    <h3>Posts by <?= Html::encode($model->name) ?></h3>
    <?php if (!empty($model->posts)): ?>
        <div class="row">
            <?php foreach ($model->posts as $post): ?>
                <div class="col-md-6 mb-3">
                    <div class="card">
                        <div class="card-body">
                            <h6 class="card-title"><?= Html::encode($post->title) ?></h6>
                            <p class="card-text"><?= $post->getContentPreview(80) ?></p>
                            <small class="text-muted"><?= Yii::$app->formatter->asDatetime($post->date) ?></small>
                        </div>
                        <div class="card-footer">
                            <?= Html::a('View', ['/post/view', 'id' => $post->idpost], ['class' => 'btn btn-sm btn-primary']) ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <p class="text-muted">No posts created by this user.</p>
    <?php endif; ?>

</div>