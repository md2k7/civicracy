		<div class="main-content">
<?php
$this->breadcrumbs=array(
	Yii::t('app', 'menu.users') => array('admin'),
	$model->username => array('view','id'=>$model->id),
	Yii::t('app', 'menu.users.update'),
);

$this->menu=array(
	array('label' => Yii::t('app', 'menu.users.create'), 'url'=>array('create')),
	array('label' => Yii::t('app', 'menu.users.viewAll'), 'url'=>array('view', 'id'=>$model->id)),
	array('label' => Yii::t('app', 'menu.users.manageAll'), 'url'=>array('admin')),
);
?>

<h1><?php echo Yii::t('app', 'users.updateOne', array('{user}' => $model->username)); ?></h1>

<?php echo $this->renderPartial('updateForm', array('model'=>$model)); ?>
		</div>