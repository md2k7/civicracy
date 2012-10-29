		<div class="main-content">
<?php
$this->breadcrumbs=array(
	Yii::t('app', 'menu.users') => array('admin'),
	$model->username,
);

$this->menu=array(
	array('label' => Yii::t('app', 'menu.users.create'), 'url'=>array('create')),
	array('label' => Yii::t('app', 'menu.users.update'), 'url'=>array('update', 'id'=>$model->id)),
	array('label' => Yii::t('app', 'menu.users.delete'), 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>Yii::t('app', 'user.deleteConfirmation'))),
	array('label' => Yii::t('app', 'menu.users.manageAll'), 'url'=>array('admin')),
);
?>

<h1><?php echo Yii::t('app', 'menu.users.viewOne', array('{user}' => $model->username)); ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'username',
		'realname',
		'email',
	),
)); ?>
		</div>