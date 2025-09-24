<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Post */

?>
<div class="card">
    <div class="card-body">
        <h5 class="card-title"><?= Html::a(Html::encode($model->title), ['/post/view', 'id' => $model->idpost]) ?></h5>
        <p class="card-text"><?= $model->getContentPreview(200) ?></p>
        <div class="d-flex justify-content-between align-items-center">
            <small class="text-muted">
                By <?= Html::encode($model->getAuthorName()) ?> 
                on <?= Yii::$app->formatter->asDatetime($model->date) ?>
            </small>
            <?= Html::a('Read More', ['/post/view', 'id' => $model->idpost], ['class' => 'btn btn-primary btn-sm']) ?>
        </div>
    </div>
</div>