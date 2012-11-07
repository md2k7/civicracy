<?php
$this->breadcrumbs=array(
	Yii::t('app', 'menu.categories') => array('admin'),
	$model->name,
);

$this->menu=array(
	array('label' => Yii::t('app', 'menu.categories.create'), 'url'=>array('create')),
	array('label' => Yii::t('app', 'menu.categories.update'), 'url'=>array('update', 'id'=>$model->id)),
	array('label' => Yii::t('app', 'menu.categories.delete'), 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'))),
	array('label' => Yii::t('app', 'menu.categories.manageAll'), 'url'=>array('admin')),
);
?>
		<div class="main-content">
<h1><?php echo Yii::t('app', 'menu.category', array('{category}' => $model->name)); ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'name',
		'description',
		'boardsize',
	),
)); ?>
		</div>