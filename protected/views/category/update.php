<?php
$this->breadcrumbs=array(
	Yii::t('app', 'Categories') => array('admin'),
	$model->name=>array('view','id'=>$model->id),
	Yii::t('app', 'Update'),
);

$this->menu=array(
	array('label' => Yii::t('app', 'Create Category'), 'url'=>array('create')),
	array('label' => Yii::t('app', 'View Category'), 'url'=>array('view', 'id'=>$model->id)),
	array('label' => Yii::t('app', 'Manage Category'), 'url'=>array('admin')),
);
?>

<h1><?php echo Yii::t('app', 'Update Category {category}', array('{category}' => $model->name)); ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
