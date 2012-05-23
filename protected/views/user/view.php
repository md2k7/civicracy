<?php
$this->breadcrumbs=array(
	Yii::t('app', 'Users') => array('admin'),
	$model->username,
);

$this->menu=array(
	array('label' => Yii::t('app', 'Create User'), 'url'=>array('create')),
	array('label' => Yii::t('app', 'Update User'), 'url'=>array('update', 'id'=>$model->id)),
	array('label' => Yii::t('app', 'Delete User'), 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>Yii::t('app', 'Are you sure you want to delete this item?'))),
	array('label' => Yii::t('app', 'Manage User'), 'url'=>array('admin')),
);
?>

<h1><?php echo Yii::t('app', 'View User {user}', array('{user}' => $model->username)); ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'username',
		'realname',
		'email',
	),
)); ?>
