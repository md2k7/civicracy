 <div class="main-content">
<?php
$this->breadcrumbs=array(
	Yii::t('app', 'menu.users') => array('admin'),
);

?>
	</div>
		
	<h1><?php echo Yii::t('app', 'menu.users.import'); ?></h1>
	<?php echo Yii::t('app', 'forms.importCSVfile'); ?>
<div class="form">
<?php echo $form; ?>
</div>
<?php if(isset($newU))
			$this->renderPartial('showImported', array('newU'=>$newU));	
	?>