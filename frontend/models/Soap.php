<?php

namespace frontend\models;

use yii\base\Model;


class Soap extends Model
{
    /**
     * @param $city
     * @param $name
     * @param $date
     * @param array ...$arg
     * @return array
     */
    public function Calculate($city, $name, $date, ...$arg)
    {
        $result = [];

        if ($date < date('Y-m-d')) {
            $result['error'] = 'Параметр "date" меньше текущего дня';
        } else {
            $result['price'] = rand(0, 999999);
            $result['info'] = \Yii::$app->getSecurity()->generateRandomString(10);
            $result['error'] = 0;
        }

        return $result;
    }
}
