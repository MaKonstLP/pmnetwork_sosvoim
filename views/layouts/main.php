<?php

/* @var $this \yii\web\View */
/* @var $content string */

use common\models\Subdomen;
use yii\helpers\Html;
//use frontend\modules\svadbanaprirode\assets\AppAsset;

frontend\modules\so_svoim\assets\AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">

<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="icon" type="image/svg+xml" href="/img/favicon/favicon.svg" sizes="120x120 | any">
    <!-- <link rel="shortcut icon" type="image/x-icon" href="/img/favicon/favicon.ico"> -->

    <link rel="apple-touch-icon" sizes="57x57" href="/img/favicon/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="/img/favicon/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="/img/favicon/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="/img/favicon/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="/img/favicon/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="/img/favicon/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="/img/favicon/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="/img/favicon/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/img/favicon/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192"  href="/img/favicon/android-icon-192x192.png">
    <!-- <link rel="icon" type="image/png" sizes="32x32" href="/img/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="/img/favicon/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/img/favicon/favicon-16x16.png"> -->
    <link rel="manifest" href="/img/favicon/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="/img/favicon/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">

    <title><?php echo $this->title ?></title>

    <?php $this->head() ?>
    <?php if (!empty($this->params['desc'])) echo "<meta name='description' content='" . $this->params['desc'] . "'>"; ?>
    <?php if (!empty($this->params['kw'])) echo "<meta name='keywords' content='" . $this->params['kw'] . "'>"; ?>
    <?= Html::csrfMetaTags() ?>
    
    <style>
    <?php 
        if (file_exists(\Yii::getAlias('@app/modules/so_svoim/web/dist/app-main.min.css'))) {
            print_r(file_get_contents(\Yii::getAlias('@app/modules/so_svoim/web/dist/app-main.min.css')));
        }
    ?>
    </style>
</head>

<body>
    <?php $this->beginBody() ?>

    <div class="main_wrap">
        <header>
            <nav class="main_menu">
                <div class="content_block">

                    <div class="menu_burger"><span></span></div>
                    <ul class="main_menu_items">
                        <li class="main_menu_item"><a href="/catalog/restoran/">Рестораны</a></li>
                        <li class="main_menu_item"><a href="/catalog/banketniy-zal/">Банкетные залы</a></li>
                        <li class="main_menu_item"><a href="/catalog/loft/">Лофт</a></li>
                        <li class="main_menu_item"><a href="/catalog/antikafe/">Антикафе</a></li>
                        <li class="main_menu_item"><a href="/catalog/bar/">Бары</a></li>
                        <li class="main_menu_item"><a href="/blog/">Статьи</a></li>
                        <li class="main_menu_item"><a href="/about-us/">О нас</a></li>
                    </ul>
                    <div class="header_city<?=(Yii::$app->controller->action->id == 'post' || Yii::$app->request->url == '/') ? ' home' : '';?>">
                        <span>Ваш город: </span>
                        <span class="city"><?= Yii::$app->params['subdomen_name'] ?></span>
                    </div>
                    <div class="city_list_wrap  mCustomScrollbar _mCS_2 _mCS_1" data-search-wrap>
                        <div class="city_list_title">Выберите город</div>
                        <!-- <input type="text" name="city" placeholder="Название города" data-search-input> -->
                        <div class="city_list">
                            <?php
                            $address = \Yii::$app->params['siteAddress'];
                            $activeSubdomenRecords = \Yii::$app->params['activeSubdomenRecords'];
                            $reduced = array_reduce($activeSubdomenRecords, function ($acc, $subdomen) use ($address) {
                                $firstLetter = mb_substr($subdomen->name, 0, 1);
                                $alias = $subdomen->city_id == 4400 ? '' : $subdomen->alias . '.';
                                $link = "<div class='city_block'><input id='$alias' type='radio' name='site' value='http://$alias$address'><label for='$alias'>$subdomen->name</label></div>";
                                // $link = "<a href='http://$alias$address' data-search-city>$subdomen->name</a>";
                                isset($acc[$firstLetter]) ? $acc[$firstLetter] .= $link : $acc[$firstLetter] = $link;
                                return $acc;
                            }, []);
                            foreach ($reduced as $letter => $links) : ?>
                                <div class='city_list_item' data-search-city_in_char_wrap>
                                    <!-- <div class='char'><?= $letter ?></div> -->
                                    <div class='city_in_char' data-search-city_in_char>
                                        <?= $links ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                            <input class="city_btn" type="button" value="Выбрать" onClick="window.location.href = document.querySelectorAll('[name=site]:checked')[0].value">
                        </div>
                    </div>
                </div>
            </nav>
            <div class="header_wrap<?=\Yii::$app->params['isHome'] ? ' home' : '';?>">
                <div class="content_block">
                    <div class="content_left_side">
                        <a href="/" class="header_logo">SO-SVOIM.RU</a>
                        <a class="header_phone" href="tel:+78465555500" data-target="telefon_1"><span>(846) 555-55-00</span></a>
                    </div>
                    <div class="content_right_side">
                        <div class="_link" data-open-popup-form data-target="podbor_1">Подобрать заведение</div>
                        <div class="_recall" data-open-recall-form>Обратный звонок</div>
                    </div>
                </div>
            </div>
        </header>

        <div class="content_wrap index_first_page">
            <?= $content ?>
        </div>

        <!-- <footer <?=Yii::$app->controller->action->id == 'post' ? ' class="__bgWhite"' : '';?>> -->
        <footer>
            <div class="footer_wrap">
                <div class="content_block">

                    <div class="footer_block _left">
                        <div class="block-left-side">
                            <a href="/" class="footer_logo">SO-SVOIM.RU</a>
                            <div class="footer_info">
                                <p class="footer_copy">so-svoim.ru   © <?php echo date("Y"); ?></p>
                                <a class="footer_pc" target="_blank" href="<?= Yii::$app->params['siteProtocol'] . '://' . Yii::$app->params['siteAddress'] ?>/politika/" >Политика конфиденциальности</a>
                            </div>
                        </div>
                        <div class="block-right-side">
                            <div class="header_city<?=(Yii::$app->controller->action->id == 'post' || Yii::$app->request->url == '/') ? ' home' : '';?>">
                                <span>Ваш город: </span>
                                <span class="city"><?= Yii::$app->params['subdomen_name'] ?></span>
                            </div>
                            <a class="footer_phone" href="tel:+78465555500" data-target="telefon_1"><span>(846) 555-55-00</span></a>
                        </div>
                    </div>

                    <div class="footer_block _right">
                        <div class="_link" data-open-popup-form data-target="podbor_1">Подобрать заведение</div>
                        <div class="_recall" data-open-recall-form>Обратный звонок</div>
                    </div>

                    <div class="footer_nav">
                        <!-- <ul class="footer_nav_wrap">
                        <?php
                            $kindArr = array_filter(Yii::$app->params['footer_slices'], function ($meta) {
                                return $meta['type'] == 'kind';
                            });
                            foreach ($kindArr as $alias => $meta) { ?>
                                <li><a href="/catalog/<?= $alias ?>/"><?= $meta['name'] ?></a><span>  <?= $meta['count'] ?></span></li>
                            <?php } ?>
                            <?php
                            $costArr = array_filter(Yii::$app->params['footer_slices'], function ($meta) {
                                return $meta['type'] == 'cost';
                            });
                            foreach ($costArr as $alias => $meta) { ?>
                                <li><a href="/catalog/<?= $alias ?>/"><?= $meta['name'] ?></a><span>  <?= $meta['count'] ?></span></li>
                            <?php } ?>
                            <?php
                            $featureArr = array_filter(Yii::$app->params['footer_slices'], function ($meta) {
                                return $meta['type'] == 'feature';
                            });
                            foreach ($featureArr as $type_alias => $meta) { ?>
                                <li><a href="/catalog/<?= $type_alias ?>/"><?= $meta['name'] ?></a><span>  <?= $meta['count'] ?></span></li>
                            <?php } ?>
                        </ul> -->
                        <ul class="footer_nav_wrap">
                            <?php
                            $kindArr = array_filter(Yii::$app->params['footer_slices'], function ($meta) {
                                return $meta['type'] == 'kind';
                            });
                            foreach ($kindArr as $alias => $meta) { ?>
                                <li><a href="/catalog/<?= $alias ?>/"><?= $meta['name'] ?></a></span></li>
                            <?php } ?>
                            <?php
                            $costArr = array_filter(Yii::$app->params['footer_slices'], function ($meta) {
                                return $meta['type'] == 'cost';
                            });
                            foreach ($costArr as $alias => $meta) { ?>
                                <li><a href="/catalog/<?= $alias ?>/"><?= $meta['name'] ?></a></li>
                            <?php } ?>
                            <?php
                            $featureArr = array_filter(Yii::$app->params['footer_slices'], function ($meta) {
                                return $meta['type'] == 'feature';
                            });
                            foreach ($featureArr as $type_alias => $meta) { ?>
                                <li><a href="/catalog/<?= $type_alias ?>/"><?= $meta['name'] ?></a></li>
                            <?php } ?>
                        </ul>
                    </div>

                </div>
            </div>
        </footer>

    </div>

    <div class="popup_wrap">
        <div class="popup_layout" data-close-popup></div>
        <div class="popup_form">
            <?= $this->render('//components/generic/form-popup.twig', ['title' => 'Затрудняетесь с выбором?', 'target' => 'podbor_popup']) ?>
        </div>
        <div class="popup_form_recall">
            <?= $this->render('//components/generic/form-recall.twig', ['title' => 'Заказать обратный звонок', 'target' => 'recall']) ?>
        </div>

        <div class="popup_img">
            <div class="popup_img_close" data-close-popup></div>
            <div class="popup_img_slider_wrap">
                <div class="object_gallery_container swiper-container" data-gallery-img-swiper>
                    <div class="object_gallery_swiper swiper-wrapper" data-gallery-list></div>
                </div>
            </div>
        </div>
    </div>

    <?php $this->endBody() ?>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap" rel="stylesheet">
    <link href="//cdn.jsdelivr.net/jquery.mcustomscrollbar/3.0.6/jquery.mCustomScrollbar.min.css" rel="stylesheet" crossorigin="anonymous">
</body>

</html>
<?php $this->endPage() ?>