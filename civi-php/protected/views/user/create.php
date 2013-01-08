		<div class="main-content">
<?php

if(property_exists(Yii::app()->user, 'isAdmin') && Yii::app()->user->isAdmin)
	$this->breadcrumbs=array(
		Yii::t('app', 'menu.users') => array('admin'),
		Yii::t('app', 'menu.create'),
	);
else
    $this->breadcrumbs=array(
		Yii::t('app', 'menu.create'),
	);

?>

<h1><?php echo Yii::t('app', 'menu.users.create'); ?></h1>

<?php echo $this->renderPartial('createForm', array('model'=>$model)); ?>
		</div>