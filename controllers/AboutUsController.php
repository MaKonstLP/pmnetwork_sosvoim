<?php

namespace app\modules\so_svoim\controllers;

use common\models\Restaurants;
use common\models\Seo;
use frontend\modules\so_svoim\components\Breadcrumbs;
use frontend\modules\so_svoim\models\ElasticItems;
use yii\web\NotFoundHttpException;

class AboutUsController extends BaseFrontendController
{
    public function actionIndex()
    {
        $seo = (new Seo('about', 1, 0))->seo;
        $this->setSeo($seo);

        return $this->render('index.twig', array(
			'seo' => $seo,
		));
    }

    private function setSeo($seo){
        $this->view->title = $seo['title'];
        $this->view->params['desc'] = $seo['description'];
        $this->view->params['kw'] = $seo['keywords'];
    }
}