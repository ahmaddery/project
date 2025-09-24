<?php

/** @var yii\web\View $this */
/** @var app\models\Post[] $recentPosts */

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Blog Yii2';
?>
<div class="site-index">

    <div class="jumbotron text-center bg-transparent mt-5 mb-5">
        <h1 class="display-4">Selamat Datang di Blog Yii2</h1>
        <p class="lead">Platform blog sederhana dengan sistem manajemen konten yang lengkap</p>
        
        <?php if (Yii::$app->user->isGuest): ?>
            <p><a class="btn btn-lg btn-success" href="<?= Url::to(['/site/login']) ?>">🔑 Login untuk Mulai Menulis</a></p>
            
            <div class="mt-4">
                <h5>👥 Sistem Role:</h5>
                <div class="row mt-3">
                    <div class="col-md-6">
                        <div class="card bg-light">
                            <div class="card-body text-center">
                                <h6 class="card-title">👨‍💼 Admin</h6>
                                <ul class="list-unstyled">
                                    <li>✅ Create/Edit/Delete ALL Posts</li>
                                    <li>✅ Manage User Accounts (CRUD)</li>
                                    <li>✅ Full Admin Access</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card bg-light">
                            <div class="card-body text-center">
                                <h6 class="card-title">✍️ Author</h6>
                                <ul class="list-unstyled">
                                    <li>✅ Create New Posts</li>
                                    <li>✅ Edit/Delete Own Posts</li>
                                    <li>❌ Cannot Manage Accounts</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <?php $user = Yii::$app->user->identity; ?>
            <div class="alert alert-info">
                <h4>Selamat Datang, <?= Html::encode($user->name) ?>!</h4>
                <p class="mb-0">
                    <strong>Role:</strong> 
                    <?php if ($user->isAdmin()): ?>
                        <span class="badge bg-danger">👨‍💼 Administrator</span>
                        <br><small class="text-muted">Anda memiliki akses penuh untuk mengelola posts dan user accounts</small>
                    <?php else: ?>
                        <span class="badge bg-info">✍️ Author</span>
                        <br><small class="text-muted">Anda dapat membuat dan mengelola post milik sendiri</small>
                    <?php endif; ?>
                </p>
            </div>
            
            <div class="mt-3">
                <a href="<?= Url::to(['/post/create']) ?>" class="btn btn-lg btn-primary me-2">📝 Buat Post Baru</a>
                <a href="<?= Url::to(['/post/index', 'manage' => 1]) ?>" class="btn btn-lg btn-outline-primary">📊 My Dashboard</a>
                <?php if ($user->isAdmin()): ?>
                    <a href="<?= Url::to(['/account/index']) ?>" class="btn btn-lg btn-outline-danger">👥 Manage Users</a>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>

    <div class="body-content">
        <h2 class="mb-4">Post Terbaru</h2>
        
        <?php if (empty($recentPosts)): ?>
            <div class="alert alert-info">
                <h4>Belum Ada Post</h4>
                <p>Saat ini belum ada post yang tersedia. 
                <?php if (!Yii::$app->user->isGuest): ?>
                    <?= Html::a('Buat post pertama', ['/post/create'], ['class' => 'btn btn-primary']) ?>
                <?php else: ?>
                    <?= Html::a('Login', ['/site/login'], ['class' => 'btn btn-success']) ?> untuk mulai menulis.
                <?php endif; ?>
                </p>
            </div>
        <?php else: ?>
            <div class="row">
                <?php foreach ($recentPosts as $post): ?>
                    <div class="col-md-6 col-lg-4 mb-4">
                        <div class="card h-100">
                            <div class="card-body">
                                <h5 class="card-title"><?= Html::encode($post->title) ?></h5>
                                <p class="card-text"><?= $post->getContentPreview(100) ?></p>
                                <small class="text-muted">
                                    Oleh <?= Html::encode($post->getAuthorName()) ?> 
                                    pada <?= Yii::$app->formatter->asDatetime($post->date) ?>
                                </small>
                            </div>
                            <div class="card-footer">
                                <?= Html::a('Baca Selengkapnya', ['/post/view', 'id' => $post->idpost], ['class' => 'btn btn-primary btn-sm']) ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            
            <div class="text-center mt-4">
                <?= Html::a('Lihat Semua Post', ['/post/index'], ['class' => 'btn btn-outline-primary']) ?>
            </div>
        <?php endif; ?>
    </div>
</div>
