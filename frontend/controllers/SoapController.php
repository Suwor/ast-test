<?php

namespace frontend\controllers;

use common\models\User;
use frontend\models\CalculateForm;
use Yii;
use yii\helpers\Url;
use yii\web\HttpException;

class SoapController extends \yii\web\Controller
{

    public function beforeAction($action)
    {
        if ($action->id == 'server') {
            $this->enableCsrfValidation = false;
        }

        return parent::beforeAction($action);
    }

    /**
     * SOAP server
     *
     * @return string
     * @throws HttpException
     */
    public function actionServer()
    {
        if(empty($_SERVER['PHP_AUTH_USER']) || empty($_SERVER['PHP_AUTH_PW']))
        {
            throw new HttpException(401, 'Unauthorized');

        } else {

            $user = User::findByUsername($_SERVER['PHP_AUTH_USER']);

            if (!$user || !$user->validatePassword($_SERVER['PHP_AUTH_PW'])) {
                throw new HttpException(403, 'Forbidden');
            }
        }

        $server = new \SoapServer(null, array('uri' => Yii::$app->request->hostInfo));
        $server->setClass('frontend\models\Soap');

        ob_start();
        $server->handle();
        $soapXml = ob_get_contents();
        ob_end_clean();

        return $soapXml;
    }

    /**
     * SOAP client
     *
     * @return string
     */
    public function actionClient()
    {
        $model = new CalculateForm();
        $result = ['price' => 0, 'info' => '', 'error' => 0];

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {

            $client = new \SoapClient(null, [
                'location' => Yii::$app->request->hostInfo . Url::toRoute('soap/server'),
                'uri' => Yii::$app->request->hostInfo,
                'login' => $model->login,
                'password' => $model->password
            ]);

            try {
                $result = $client->Calculate($model->city, $model->name, $model->date);
            } catch (\SoapFault  $e) {
                $result['error'] = $e->getMessage();
            }
        }

        return $this->render('calculate', [
            'model'  => $model,
            'result' => $result
        ]);
    }
}
