<?php
$this->breadcrumbs=array(
	Yii::t('app', 'menu.users') => array('admin'),
	Yii::t('app', 'menu.manage'),
);

$this->menu=array(
	array('label' => Yii::t('app', 'menu.users.create'), 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('user-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
		<div class="main-content">
<h1><?php echo Yii::t('app', 'menu.users.manageAll'); ?></h1>

<?php echo Yii::t('app', 'forms.compareOperators'); ?>

<?php echo CHtml::link( Yii::t('app', 'forms.advancedSearch'),'#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php

$condition = User::model()->activeUserConditions();

$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'user-grid',
	'dataProvider'=>new CActiveDataProvider('User', array(
		'criteria'=>array(
			'condition'=>$condition['condition'],
			'params'=>$condition['params'],
		),
		'pagination'=>array(
			'pageSize'=>20,
		)
	)),
	'filter'=>$model,
	'columns'=>array(
		'username',
		'realname',
		'email',
		array(
			'class'=>'CButtonColumn',
			'deleteConfirmation'=>Yii::t('app', 'user.deleteConfirmation'),
		),
	),
)); ?>
		</div>