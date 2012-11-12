<?php
$this->breadcrumbs=array(
	Yii::t('app', 'menu.users') => array('admin'),
	Yii::t('app', 'menu.manage'),
);

$this->menu=array(
	array('label' => Yii::t('app', 'menu.users.create'), 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('user-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
		<div class="main-content">
<h3><?php echo Yii::t('app', 'menu.users.displayImported'); ?></h3>

<?php echo Yii::t('app', 'forms.displayImported'); ?>

<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>new User,
)); ?>
</div><!-- search-form -->

<?php 
$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'user-grid',
	'dataProvider'=> new CArrayDataProvider($newU, array(
		'id'=>'id',
		'sort'=>array(
				'attributes'=>array(
						'id', 'username', 'email',
				),
		),
		'pagination'=>array(
				'pageSize'=>100,
		),
	)),
	'columns'=>array(
		'username',
		'realname',
		'email',
		array(
			'class'=>'CButtonColumn',
			'deleteConfirmation'=>Yii::t('app', 'user.deleteConfirmation'),
		),
	),
)); ?>
<a class="btn btn-primary btn-civi" href="<?php echo $this->createUrl('import', array('sendemail' => 'true')); ?>"><?php echo Yii::t('app', 'user.import.confirmEmailSend');; ?></a>
		</div>