<?php

/** @var yii\web\View $this */
/** @var string $content */

use app\assets\AppAsset;
use app\widgets\Alert;
use yii\bootstrap5\Breadcrumbs;
use yii\bootstrap5\Html;
use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;

AppAsset::register($this);

// Register custom CSS
$this->registerCssFile('@web/css/custom.css');

$this->registerCsrfMetaTags();
$this->registerMetaTag(['charset' => Yii::$app->charset], 'charset');
$this->registerMetaTag(['name' => 'viewport', 'content' => 'width=device-width, initial-scale=1, shrink-to-fit=no']);
$this->registerMetaTag(['name' => 'description', 'content' => $this->params['meta_description'] ?? '']);
$this->registerMetaTag(['name' => 'keywords', 'content' => $this->params['meta_keywords'] ?? '']);
$this->registerLinkTag(['rel' => 'icon', 'type' => 'image/x-icon', 'href' => Yii::getAlias('@web/favicon.ico')]);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">
<head>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body class="d-flex flex-column h-100">
<?php $this->beginBody() ?>

<header id="header">
    <?php
    NavBar::begin([
        'brandLabel' => Yii::$app->name,
        'brandUrl' => Yii::$app->homeUrl,
        'options' => ['class' => 'navbar-expand-md navbar-dark bg-dark fixed-top']
    ]);
    $navItems = [
        ['label' => 'Beranda', 'url' => ['/site/index']],
        ['label' => 'Posts', 'url' => ['/post/index']],
    ];
    
    if (!Yii::$app->user->isGuest) {
        $user = Yii::$app->user->identity;
        
        // Menu Manage untuk user yang login
        $manageItems = [
            ['label' => 'My Posts', 'url' => ['/post/index', 'manage' => 1]],
            ['label' => 'Create New Post', 'url' => ['/post/create']],
        ];
        
        // Admin dapat mengelola accounts
        if ($user->isAdmin()) {
            $manageItems[] = '<li class="dropdown-divider"></li>';
            $manageItems[] = ['label' => 'Manage Accounts', 'url' => ['/account/index']];
            $manageItems[] = ['label' => 'Create Account', 'url' => ['/account/create']];
        }
        
        $navItems[] = [
            'label' => 'Manage',
            'items' => $manageItems
        ];
        
        // User menu dengan info role dan logout
        $navItems[] = [
            'label' => $user->name . ' (' . ucfirst($user->role) . ')',
            'items' => [
                ['label' => 'Dashboard', 'url' => ['/post/index', 'manage' => 1]],
                '<li class="dropdown-divider"></li>',
                [
                    'label' => 'Logout',
                    'url' => ['/site/logout'],
                    'linkOptions' => [
                        'data-method' => 'post',
                        'data-confirm' => 'Are you sure you want to logout?'
                    ]
                ]
            ]
        ];
        
        // Tambahan button logout terpisah untuk visibility yang lebih baik
        $navItems[] = [
            'label' => 'Logout',
            'url' => ['/site/logout'],
            'linkOptions' => [
                'data-method' => 'post',
                'data-confirm' => 'Are you sure you want to logout?',
                'class' => 'btn btn-outline-light btn-sm ms-2'
            ]
        ];
    } else {
        $navItems[] = ['label' => 'Login', 'url' => ['/site/login']];
    }
    
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav'],
        'items' => $navItems
    ]);
    NavBar::end();
    ?>
</header>

<main id="main" class="flex-shrink-0" role="main">
    <div class="container">
        <?php if (!empty($this->params['breadcrumbs'])): ?>
            <?= Breadcrumbs::widget(['links' => $this->params['breadcrumbs']]) ?>
        <?php endif ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</main>

<footer id="footer" class="mt-auto py-3 bg-light">
    <div class="container">
        <div class="row text-muted">
            <div class="col-md-6 text-center text-md-start">&copy; My Company <?= date('Y') ?></div>
            <div class="col-md-6 text-center text-md-end"><?= Yii::powered() ?></div>
        </div>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
