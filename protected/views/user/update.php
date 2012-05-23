<?php
$this->breadcrumbs=array(
	Yii::t('app', 'Users') => array('admin'),
	$model->username => array('view','id'=>$model->id),
	Yii::t('app', 'Update'),
);

$this->menu=array(
	array('label' => Yii::t('app', 'Create User'), 'url'=>array('create')),
	array('label' => Yii::t('app', 'View User'), 'url'=>array('view', 'id'=>$model->id)),
	array('label' => Yii::t('app', 'Manage User'), 'url'=>array('admin')),
);
?>

<h1><?php echo Yii::t('app', 'Update User {user}', array('{user}' => $model->username)); ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
