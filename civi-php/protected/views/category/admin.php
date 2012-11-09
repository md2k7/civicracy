<?php
$this->breadcrumbs=array(
	Yii::t('app', 'menu.categories') => array('admin'),
	Yii::t('app', 'menu.manage'),
);

$this->menu=array(
	array('label' => Yii::t('app', 'menu.categories.create'), 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('category-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
		<div class="main-content">
<h1><?php echo Yii::t('app', 'menu.categories.manageAll'); ?></h1>

<?php echo Yii::t('app', 'forms.compareOperators'); ?>

<?php echo CHtml::link(Yii::t('app', 'forms.advancedSearch'), '#', array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'category-grid',
	'dataProvider'=>new CActiveDataProvider('Category', array(
		'criteria'=>array(
			'condition'=>'active = :active',
			'params'=>array('active'=>1),
		),
		'pagination'=>array(
			'pageSize'=>20,
		)
	)),
	'filter'=>$model,
	'columns'=>array(
		'name',
		'description',
		'boardsize',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
		</div>