<?php
$this->breadcrumbs=array(
	Yii::t('app', 'menu.categories') => array('admin'),
	Yii::t('app', 'menu.create'),
);

$this->menu=array(
	array('label' => Yii::t('app', 'menu.categories.manageAll'), 'url'=>array('admin')),
);
?>

<h1><?php echo Yii::t('app', 'menu.categories.create'); ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
