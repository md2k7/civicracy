	<div class="main-content">
<?php
$this->breadcrumbs=array(
	Yii::t('app', 'menu.users') => array('admin'),
	$model->username,
);

?>
	</div>
		
	<h1><?php echo Yii::t('app', 'menu.users.import'); ?></h1>

<?php echo $this->renderPartial('importForm', array('model'=>$model)); ?>