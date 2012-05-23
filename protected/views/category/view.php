<?php
$this->breadcrumbs=array(
	Yii::t('app', 'Categories') => array('admin'),
	$model->name,
);

$this->menu=array(
	array('label' => Yii::t('app', 'Create Category'), 'url'=>array('create')),
	array('label' => Yii::t('app', 'Update Category'), 'url'=>array('update', 'id'=>$model->id)),
	array('label' => Yii::t('app', 'Delete Category'), 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'))),
	array('label' => Yii::t('app', 'Manage Category'), 'url'=>array('admin')),
);
?>

<h1><?php echo Yii::t('app', 'Category {category}', array('{category}' => $model->name)); ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'name',
	),
)); ?>
