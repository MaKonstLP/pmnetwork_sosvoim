<?php

namespace app\modules\so_svoim;

use common\models\Filter;
use common\models\Slices;
use common\models\Subdomen;
use frontend\components\ParamsFromQuery;
use frontend\components\QueryFromSlice;
use Yii;
use yii\web\Cookie;
use yii\web\NotFoundHttpException;

/**
 * svadbanaprirode module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'app\modules\so_svoim\controllers';

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();

        $currentSubdomenAlias = explode('.', $_SERVER['HTTP_HOST'])[0];
        $siteName = explode(".", \Yii::$app->params['siteAddress'])[0];
        Yii::$app->params['domen'] = $_SERVER['HTTP_HOST'];
        $subdomens = Yii::$app->params['activeSubdomenRecords'] = Subdomen::find()
            ->where(['active' => 1])
            ->orderBy(['name' => SORT_ASC])
            ->all();;

        if ($currentSubdomenAlias != $siteName) {
            $subdomen_model = current(array_filter($subdomens, function ($subdomen) use ($currentSubdomenAlias) {
                return $subdomen->alias == $currentSubdomenAlias;
            }));

            if (empty($subdomen_model) || $subdomen_model->city_id == 4400) {
                return $this->redirect(Yii::$app->params['siteProtocol'] . '://' . \Yii::$app->params['siteAddress'] . "$_SERVER[REQUEST_URI]");
            }

            Yii::$app->params['subdomen'] = $currentSubdomenAlias;
            Yii::$app->params['subdomen_id'] = $subdomen_model->city_id;
            Yii::$app->params['subdomen_alias'] = $subdomen_model->alias;
            Yii::$app->params['subdomen_baseid'] = $subdomen_model->id;
            Yii::$app->params['subdomen_name'] = $subdomen_model->name;
            Yii::$app->params['subdomen_dec'] = $subdomen_model->name_dec;
            Yii::$app->params['subdomen_rod'] = $subdomen_model->name_rod;

            $subdomenCookie = \Yii::$app->request->cookies->get('subdomen');
            if (empty($subdomenCookie) || $subdomenCookie != $currentSubdomenAlias) {
                \Yii::$app->response->cookies->add(new Cookie([
                    'name' => 'subdomen',
                    'value' => $currentSubdomenAlias,
                    'expire' => time() + 86400 * 30,
                    'domain' => '.' . explode(":", \Yii::$app->params['siteAddress'])[0]
                ]));
            }
        } elseif (
            $currentSubdomenAlias != $siteName
            && $subdomen_cookie = \Yii::$app->request->cookies->get('subdomen')
        ) {
            return $this->redirect = Yii::$app->params['siteProtocol'] . '://' . $subdomen_cookie . \Yii::$app->params['siteAddress'] . "$_SERVER[REQUEST_URI]";
        } else {
            $subdomen_model = current(array_filter($subdomens, function ($subdomen) {
                return $subdomen->city_id == 4400;
            }));
            if (empty($subdomen_model)) {
                \Yii::$app->response->cookies->remove('subdomen');
                return $this->redirect(Yii::$app->params['siteProtocol'] . '://' . \Yii::$app->params['siteAddress'] . "$_SERVER[REQUEST_URI]");
            }
            Yii::$app->params['subdomen'] = $currentSubdomenAlias;
            Yii::$app->params['subdomen_id'] = $subdomen_model->city_id;
            Yii::$app->params['subdomen_alias'] = $subdomen_model->alias;
            Yii::$app->params['subdomen_baseid'] = $subdomen_model->id;
            Yii::$app->params['subdomen_name'] = $subdomen_model->name;
            Yii::$app->params['subdomen_dec'] = $subdomen_model->name_dec;
            Yii::$app->params['subdomen_rod'] = $subdomen_model->name_rod;
        }

        $subdomenId = Yii::$app->params['subdomen_baseid'];
        Yii::$app->params['filter_model'] = Filter::find()
            ->where(['active' => 1])
            ->orderBy(['sort' => SORT_ASC])
            ->all();
        Yii::$app->params['slices_model'] = Slices::find()->all();

        $footerSlices = [
            'restoran' => ['name' => 'Рестораны', 'type' => 'kind','count' => 0],
            'kafe' => ['name' => 'Кафе', 'type' => 'kind','count' => 0],
            'kottedzh' => ['name' => 'Коттеджи', 'type' => 'kind','count' => 0],
            'bar' => ['name' => 'Бары', 'type' => 'kind','count' => 0],
            'otel' => ['name' => 'Отели/Гостиницы', 'type' => 'kind','count' => 0],
            'loft' => ['name' => 'Лофты', 'type' => 'kind','count' => 0],
            'veranda' => ['name' => 'Веранды/Террасы', 'type' => 'kind','count' => 0],
            'baza-otdiha' => ['name' => 'Базы отдыха', 'type' => 'kind','count' => 0],
            'sauna' => ['name' => 'Бани/Сауны', 'type' => 'kind','count' => 0],
            'letnyaya-ploshadka' => ['name' => 'Летние площадки', 'type' => 'kind','count' => 0],
            'shater' => ['name' => 'Шатры', 'type' => 'kind','count' => 0],
            'detskaya-ploshadka' => ['name' => 'Детские площадки', 'type' => 'kind','count' => 0],
            'banketniy-zal' => ['name' => 'Банкетные залы', 'type' => 'kind','count' => 0],
            'antikafe' => ['name' => 'Антикафе', 'type' => 'kind','count' => 0],

            '1000-rub' => ['name' => 'до 1000 руб', 'type' => 'cost','count' => 0],
            '1500-rub' => ['name' => 'до 1500 руб', 'type' => 'cost','count' => 0],
            '2000-rub' => ['name' => 'до 2000 руб', 'type' => 'cost','count' => 0],
            '2500-rub' => ['name' => 'до 2500 руб', 'type' => 'cost','count' => 0],
            '3000-rub' => ['name' => 'до 3000 руб', 'type' => 'cost','count' => 0],

            'za-gorodom' => ['name' => 'За городом', 'type' => 'feature','count' => 0],
            'svoy-alko' => ['name' => 'Со своим алкоголем', 'type' => 'feature','count' => 0],
            'u-vodi' => ['name' => 'У воды', 'type' => 'feature','count' => 0],
        ];
        foreach ($footerSlices as $alias => $sliceTexts) {
            $slice_obj = new QueryFromSlice($alias);
            $temp_params = new ParamsFromQuery($slice_obj->params, Yii::$app->params['filter_model'], Yii::$app->params['slices_model']);
            $footerSlices[$alias]['count'] = $temp_params->query_hits;
            // echo '<pre>';
            // print_r($temp_params);
            // exit;
        }
        Yii::$app->params['footer_slices'] = array_filter($footerSlices, function ($slice) {
            return $slice['count'] > 0;
        });

        Yii::$app->params['footer_slices'] = $footerSlices;

        //echo '<pre>';
        //print_r(Yii::$app->params['footer_slices']);
        //exit;
    }

    private function redirect($redirect)
    {
        header("Location: $redirect");
        die();
    }
}
