<?php

$this->breadcrumbs=array(
    Yii::t('app', 'menu.vote'),
);

?>
<h1><?php echo Yii::t('app', 'vote.greeting', array('{realname}' => Yii::app()->user->realname)); ?></h1>

<h2><?php echo Yii::t('app', 'vote.ownWeight'); ?></h2>
<?php $this->renderPartial('ownWeight'); ?>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'own-votes-grid',
	'dataProvider'=>$ownWeight,
	'columns'=>array(
		array(
			'header' => VoteCount::model()->getAttributeLabel('categoryName'),
			'value' => '$data->categoryName',
		),
		array(
			'header' => VoteCount::model()->getAttributeLabel('voteCount'),
			'value' => '$data->voteCount',
		),
	),
)); ?>


<h2><?php echo Yii::t('app', 'vote.votedFor'); ?></h2>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'voted-grid',
	'dataProvider'=>$votedFor,
	'afterAjaxUpdate'=>"function(id, data){ $.fn.yiiGridView.update('vote-grid'); }",
	'columns'=>array(
		'name', // category name
		array(
			'header' => User::model()->getAttributeLabel('realname'),
			'value' => '$data->getCandidate()->realname',
		),
		array(
			'class' => 'CButtonColumn',
		),
	),
)); ?>


<h2><?php echo Yii::t('app', 'vote.yetToVote'); ?></h2>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'vote-grid',
	'dataProvider'=>$freeVote,
	'columns'=>array(
		'name', // category name
		array(
			'class' => 'CButtonColumn',
			'template' => '{update}',
		),
	),
)); ?>
