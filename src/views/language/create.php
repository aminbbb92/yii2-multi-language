<?php

use aminbbb92\language\models\Language;
use aminbbb92\language\Translate;
use yii\web\View;

/* @var $this View */
/* @var $model Language */
$this->params['breadcrumbs'][] = [
    'label' => Translate::language(),
    'url' => ['list'],
];
$this->params['breadcrumbs'][] = Translate::create();
?>
<div class="aminbbb92-language">
    <div class="card">
        <div class="card-header">
            <h1><?= Translate::language() ?>
                <small>
                    <i class="ace-icon fa fa-angle-double-right"></i> <?= Translate::add_a_new() ?>
                </small>
            </h1>
        </div>
        <div class="card-body">
            <?= $this->render('_form', [
                'model' => $model,
            ]) ?>
        </div>
    </div>
</div>

