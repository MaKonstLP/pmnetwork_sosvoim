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

    <link rel="icon" href="/img/bd/favicon.ico">
    <link type="image/x-icon" rel="shortcut icon" href="/img/bd/favicon.ico">
    <link type="image/png" sizes="16x16" rel="icon" href="/img/bd/favicon-16x16.png">
    <link type="image/png" sizes="32x32" rel="icon" href="/img/bd/favicon-32x32.png">
    <link type="image/png" sizes="192x192" rel="icon" href="/img/bd/android-chrome-192x192.png">
    <link rel="apple-touch-icon" href="/img/bd/apple-touch-icon.png">
    <meta name="msapplication-square150x150logo" content="/img/bd/mstile-150x150.png">
    <meta name="msapplication-config" content="/img/bd/browserconfig.xml">
    <link rel="manifest" href="/img/bd/webmanifest.json">

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
                    <ul class="main_menu_items">
                        <li class="main_menu_item"><a href="/catalog/restoran/">Рестораны</a></li>
                        <li class="main_menu_item"><a href="#">Банкетные залы</a></li>
                        <li class="main_menu_item"><a href="/catalog/loft/">Лофт</a></li>
                        <li class="main_menu_item"><a href="#">Антикафе</a></li>
                        <li class="main_menu_item"><a href="/catalog/bar/">Бары</a></li>
                        <li class="main_menu_item"><a href="#">Статьи</a></li>
                    </ul>
                    <div class="header_city<?=(Yii::$app->controller->action->id == 'post' || Yii::$app->request->url == '/') ? ' home' : '';?>">
                        <span>Ваш город: </span>
                        <span class="city"><?= Yii::$app->params['subdomen_name'] ?></span>
                    </div>
                    <div class="city_list_wrap" data-search-wrap>
                        <div class="city_list_title">Выберите город</div>
                        <!-- <input type="text" name="city" placeholder="Название города" data-search-input> -->
                        <div class="city_list">
                            <?php
                            $address = \Yii::$app->params['siteAddress'];
                            $activeSubdomenRecords = \Yii::$app->params['activeSubdomenRecords'];
                            $reduced = array_reduce($activeSubdomenRecords, function ($acc, $subdomen) use ($address) {
                                // $firstLetter = mb_substr($subdomen->name, 0, 1);
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
            <div class="header_wrap<?=(Yii::$app->controller->action->id == 'post' || Yii::$app->request->url == '/') ? ' home' : '';?>">
                <div class="content_block">
                    <div class="content_left_side">
                        <a href="/" class="header_logo">SO-SVOIM.RU</a>
                        <a class="header_phone" href="tel:+79252380246" data-target="telefon_1"><span>(846) 555-55-00<span></a>
                    </div>
                    <div class="content_right_side">
                        <div class="_link" data-open-popup-form data-target="podbor_1">Подобрать заведение</div>
                        <div class="_recall">Обратный звонок</div>
                    </div>
                </div>
            </div>
        </header>

        <div class="content_wrap index_first_page">
            <?= $content ?>
        </div>

        <footer<?=Yii::$app->controller->action->id == 'post' ? ' class="__bgWhite"' : '';?>>
            <div class="footer_wrap">
                <div class="footer_row">
                    <div class="footer_block _left">
                        <a href="/" class="footer_logo">
                            <div class="footer_logo_img"></div>
                        </a>
                        <a href="/" class="footer_logo footer_logo_2">
                            <div class="footer_logo_text">МОЙ ДЕНЬ</div>
                        </a>
                        <div class="footer_info">
                            <p class="footer_copy">© <?php echo date("Y"); ?> Мой день</p>
                            <a target="_blank" href="<?= Yii::$app->params['siteProtocol'] . '://' . Yii::$app->params['siteAddress'] ?>/politika/" class="footer_pc _link">Политика конфиденциальности</a>
                        </div>
                        <div class="footer_nav">
                            <ul class="footer_nav_wrap">
                                <li>
                                    <span>Типы заведения</span>
                                    <ul>
                                        <?php
                                        $kindArr = array_filter(Yii::$app->params['footer_slices'], function ($meta) {
                                            return $meta['type'] == 'kind';
                                        });
                                        foreach ($kindArr as $alias => $meta) { ?>
                                            <li><a href="/catalog/<?= $alias ?>/"><?= $meta['name'] ?></a></li>
                                        <?php } ?>
                                    </ul>
                                </li>
                                <li>
                                    <span>Особенности</span>
                                    <ul>
                                        <?php
                                        $featureArr = array_filter(Yii::$app->params['footer_slices'], function ($meta) {
                                            return $meta['type'] == 'feature';
                                        });
                                        foreach ($featureArr as $type_alias => $meta) { ?>
                                            <li><a href="/catalog/<?= $type_alias ?>/"><?= $meta['name'] ?></a></li>
                                        <?php } ?>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="footer_block _right">

                        <a class="footer_ph" href="tel:+79252380246" data-target="telefon_1">8 (925) 238-02-46</a>

                    </div>
                </div>
            </div>
        </footer>

    </div>

    <div class="popup_wrap">
        <div class="popup_layout" data-close-popup></div>
        <div class="popup_form">
            <?= $this->render('//components/generic/form.twig', ['title' => 'Помочь подобрать зал?', 'type' => 'header', 'target' => 'podbor_2']) ?>
        </div>
        <!-- <div class="popup_img">
            <div class="popup_img_close" data-close-popup></div>
            <div class="popup_img_slider_wrap">
                <div class="slider_arrow _prev"></div>
                <div class="slider_arrow _next"></div>
                <div class="object_gallery_container swiper-container" data-gallery-img-swiper>
                    <div class="object_gallery_swiper swiper-wrapper" data-gallery-list></div>
                </div>
            </div>
        </div> -->

    </div>


    <?php $this->endBody() ?>
    <!--link href="https://fonts.googleapis.com/css?family=Montserrat:400,500,600&display=swap&subset=cyrillic" rel="stylesheet"-->

    <!-- <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;0,800;1,400;1,600;1,800&display=swap&subset=cyrillic" rel="stylesheet" crossorigin="anonymous"> -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap" rel="stylesheet">
    <link href="//cdn.jsdelivr.net/jquery.mcustomscrollbar/3.0.6/jquery.mCustomScrollbar.min.css" rel="stylesheet" crossorigin="anonymous">
</body>

</html>
<?php $this->endPage() ?>