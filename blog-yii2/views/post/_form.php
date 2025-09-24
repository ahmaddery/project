<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Account;

/* @var $this yii\web\View */
/* @var $model app\models\Post */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="post-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'content')->textarea(['rows' => 8]) ?>

    <?php if (!Yii::$app->user->isGuest && Yii::$app->user->identity->isAdmin()): ?>
        <?= $form->field($model, 'username')->dropDownList(
            yii\helpers\ArrayHelper::map(Account::find()->all(), 'username', 'name'),
            ['prompt' => 'Select Author']
        ) ?>
    <?php else: ?>
        <?= $form->field($model, 'username')->hiddenInput()->label(false) ?>
        <div class="alert alert-info">
            <strong>Author:</strong> <?= Html::encode(Yii::$app->user->identity->name) ?>
        </div>
    <?php endif; ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
        <?= Html::a('Cancel', ['index'], ['class' => 'btn btn-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>