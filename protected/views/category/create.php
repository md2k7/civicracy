<?php
$this->breadcrumbs=array(
	Yii::t('app', 'Categories') => array('admin'),
	Yii::t('app', 'Create'),
);

$this->menu=array(
	array('label' => Yii::t('app', 'Manage Category'), 'url'=>array('admin')),
);
?>

<h1><?php echo Yii::t('app', 'Create Category'); ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
