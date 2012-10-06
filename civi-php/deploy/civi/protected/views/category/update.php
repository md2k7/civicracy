<?php
$this->breadcrumbs=array(
	Yii::t('app', 'menu.categories') => array('admin'),
	$model->name=>array('view','id'=>$model->id),
	Yii::t('app', 'menu.update'),
);

$this->menu=array(
	array('label' => Yii::t('app', 'menu.categories.create'), 'url'=>array('create')),
	array('label' => Yii::t('app', 'menu.categories.view'), 'url'=>array('view', 'id'=>$model->id)),
	array('label' => Yii::t('app', 'menu.categories.manageAll'), 'url'=>array('admin')),
);
?>

<h1><?php echo Yii::t('app', 'menu.categories.updateOne', array('{category}' => $model->name)); ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
