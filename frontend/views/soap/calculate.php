<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use kartik\date\DatePicker;
use yii\widgets\Pjax;

$this->title = 'Calculate';
?>
<div class="site-contact">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>

    </p>

    <?php Pjax::begin(['timeout' => 5000, 'formSelector' => '#calculate-form']); ?>
    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'calculate-form']); ?>

                <?= $form->field($model, 'city')->textInput(['autofocus' => true]) ?>

                <?= $form->field($model, 'name') ?>

                <?= $form->field($model, 'date')->widget(DatePicker::class, [
                    'type' => DatePicker::TYPE_COMPONENT_PREPEND,
                    'pluginOptions' => [
                        'todayHighlight'=>true,
                        'autoclose'=>true,
                        'format' => 'yyyy-mm-dd'
                    ],
                ]) ?>

                <?= $form->field($model, 'login') ?>

                <?= $form->field($model, 'password')->passwordInput() ?>

                <div class="form-group">
                    <?= Html::submitButton('Рассчитать', ['class' => 'btn btn-primary', 'name' => 'calculate-button']) ?>
                </div>

            <?php ActiveForm::end(); ?>
        </div>
        <div class="col-lg-5">
            <?php if($result['error']) : ?>
            <div class="alert alert-danger">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="alert-heading">Ошибка!</h4>
                <p><?= Html::encode($result['error']) ?></p>
            </div>
            <?php elseif($result['price'] || $result['info']): ?>
                <div class="alert alert-success">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <p>Price: <?= Html::encode($result['price']) ?></p>
                    <p>Info: <?= Html::encode($result['info']) ?></p>
                    <p>Error: <?= Html::encode($result['error']) ?></p>
                </div>
            <?php endif; ?>
        </div>
    </div>
    <?php Pjax::end(); ?>

</div>
