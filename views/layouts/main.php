<?php
/** @var yii\web\View $this */
/** @var string $content */
use app\assets\AppAsset;
use app\models\User;
use yii\bootstrap4\Html;
use yii\helpers\Url;
AppAsset::register($this);

if ($id = \Yii::$app->user->getId()) {
    $this->context->userProfile = User::findOne($id);
} else {
    $this->context->userProfile = null;
}
?>

<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language; ?>" class="h-100">
<head>
    <meta charset="<?= Yii::$app->charset; ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <?php $this->registerCsrfMetaTags(); ?>
    <title><?= Html::encode($this->title); ?></title>
    <?php $this->head(); ?>
</head>
<body class="d-flex flex-column h-100">
<?php $this->beginBody(); ?>
<header class="page-header">
    <nav class="main-nav">
        <a href='<?= Url::home(); ?>' class="header-logo">
            <img class="logo-image" src="<?= Url::to(['@web/img/logotype.png']); ?>" width=227 height=60 alt="taskforce">
        </a>
        <?php if(!Yii::$app->user->isGuest): ?>
        <div class="nav-wrapper">
            <ul class="nav-list">
                <li class="list-item list-item--active">
                    <a class="link link--nav" >Новое</a>
                </li>
                <li class="list-item">
                    <a href="#" class="link link--nav" >Мои задания</a>
                </li>
                <li class="list-item">
                    <a href="<?= Url::to(['/add-task']); ?>" class="link link--nav" >Создать задание</a>
                </li>
                <li class="list-item">
                    <a href="#" class="link link--nav" >Настройки</a>
                </li>
            </ul>
        </div>
        <?php endif; ?>
    </nav>
    <?php if(Yii::$app->controller->id !== 'registration'): ?>
    <div class="user-block">
        <a href="#">
            <img class="user-photo" src="<?= Url::to(['@web/img/man-glasses.png']); ?>" width="55" height="55" alt="Аватар">
        </a>
        <div class="user-menu">
            <p class="user-name"><?= $this->context->userProfile->name; ?></p>
            <div class="popup-head">
                <ul class="popup-menu">
                    <li class="menu-item">
                        <a href="#" class="link">Настройки</a>
                    </li>
                    <li class="menu-item">
                        <a href="#" class="link">Связаться с нами</a>
                    </li>
                    <li class="menu-item">
                        <a href="<?= Url::to(['user/logout']); ?>" class="link">Выход из системы</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <?php endif; ?>
</header>
<?= $content; ?>
<?php $this->endBody(); ?>
</body>
</html>
<?php $this->endPage(); ?>
