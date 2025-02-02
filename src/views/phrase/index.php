<?php
/**
 * Created by aminbbb92.
 * @project nic
 * @author  Phuong
 * @email   phuong17889[at]gmail.com
 * @date    04/02/2016
 * @time    2:35 CH
 */
use kartik\grid\GridView;
use aminbbb92\language\models\search\PhraseSearch;
use aminbbb92\language\Translate;
use yii\data\ActiveDataProvider;
use yii\web\View;

/* @var $this View */
/* @var $searchModel PhraseSearch */
/* @var $dataProvider ActiveDataProvider */
$this->title                   = Translate::list_x(Translate::phrase());
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="aminbbb92-language">
	<div class="col-sm-12">
		<div class="page-header">
			<h1><?= Translate::phrase() ?>
				<small><i class="ace-icon fa fa-angle-double-right"></i> <?= Translate::list_x(Translate::phrase()) ?>
				</small>
			</h1>
		</div>
		<div class="space-6"></div>
		<?= GridView::widget([
			'id'           => 'phrase',
			'dataProvider' => $dataProvider,
			'filterModel'  => $searchModel,
			'responsive'   => true,
			'hover'        => true,
			'pjax'         => true,
			'export'       => false,
			'columns'      => $searchModel->phraseColumns(),
		]); ?>
	</div>
</div>