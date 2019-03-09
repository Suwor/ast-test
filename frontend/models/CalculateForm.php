<?php

namespace frontend\models;

use Yii;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class CalculateForm extends Model
{
    public $city;
    public $name;
    public $date;
    public $login;
    public $password;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['city', 'name', 'date', 'login', 'password'], 'required'],
            ['date', 'date', 'format' => 'yyyy-mm-dd'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'city' => 'Город',
            'name' => 'Имя',
            'date' => 'Дата',
            'login' => 'Логин',
            'password' => 'Пароль',
        ];
    }
}
