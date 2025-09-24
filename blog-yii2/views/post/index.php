<?php

use yii\helpers\Html;
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $manageMode bool */

$this->title = $manageMode ? 'Manage Posts' : 'All Posts';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="post-index">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1><?= Html::encode($this->title) ?></h1>
        <div>
            <?php if (!$manageMode): ?>
                <?= Html::a('View All Posts', ['index'], ['class' => 'btn btn-outline-primary']) ?>
            <?php else: ?>
                <?= Html::a('Public View', ['index'], ['class' => 'btn btn-outline-secondary']) ?>
            <?php endif; ?>
            
            <?php if (!Yii::$app->user->isGuest): ?>
                <?= Html::a('Create New Post', ['create'], ['class' => 'btn btn-success']) ?>
                <?php if (!$manageMode): ?>
                    <?= Html::a('Manage My Posts', ['index', 'manage' => 1], ['class' => 'btn btn-primary']) ?>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>

    <?= ListView::widget([
        'dataProvider' => $dataProvider,
        'itemView' => $manageMode ? '_item_manage' : '_item',
        'layout' => "{items}\n{pager}",
        'itemOptions' => ['class' => 'mb-4'],
    ]); ?>

</div>