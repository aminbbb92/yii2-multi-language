<?php
/**
 * Created by aminbbb92.
 * @project Yii2 Multi Language
 * @author  Phuong
 * @email   phuong17889[at]gmail.com
 * @date    04/02/2016
 * @time    1:44 CH
 */
use kartik\grid\GridView;
use aminbbb92\language\models\search\LanguageSearch;
use aminbbb92\language\Translate;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;
use yii\web\View;

/* @var $this View */
/* @var $searchModel LanguageSearch */
/* @var $dataProvider ActiveDataProvider */
$this->params['breadcrumbs'][] = Translate::languages();
?>
<div class="aminbbb92-language">
    <div class="card">
        <div class="card-header">
            <h1><?= Translate::language() ?>
                <small>
                    <i class="ace-icon fa fa-angle-double-right"></i> <?= Translate::list_x([Translate::language()]) ?>
                </small>
            </h1>
        </div>
        <div class="card-body">
            <p>
                <?= Html::a(Translate::add_a_new_x([Translate::language()]), ['create'], ['class' => 'btn btn-success']) ?>
            </p>
            <?= GridView::widget([
                'id'           => 'language',
                'dataProvider' => $dataProvider,
                'filterModel'  => $searchModel,
                'export'       => false,
                'responsive'   => true,
                'hover'        => true,
                'pjax'         => true,
                'columns'      => [
                    ['class' => 'kartik\grid\SerialColumn'],
                    [
                        'attribute' => 'name',
                        'vAlign'    => 'middle',
                    ],
                    [
                        'attribute' => 'code',
                        'vAlign'    => 'middle',
                    ],
                    [
                        'attribute' => 'country',
                        'vAlign'    => 'middle',
                    ],
                    [
                        'class'      => 'kartik\grid\BooleanColumn',
                        'trueLabel'  => Translate::in_use(),
                        'falseLabel' => Translate::not_in_use(),
                        'attribute'  => 'status',
                        'vAlign'     => 'middle',
                    ],
                    [
                        'class'    => 'yii\grid\ActionColumn',
                        'template' => '{update}{delete}',
                    ],
                ],
            ]); ?>
        </div>
    </div>
</div>
<script>
	<?php if(Yii::$app->getSession()->hasFlash('message')):?>
	alert('<?=Yii::$app->getSession()->getFlash('message')?>');
	<?php endif;?>
</script>
