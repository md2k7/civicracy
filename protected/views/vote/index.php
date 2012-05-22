<?php
$this->breadcrumbs=array(
    'Vote'=>array('/vote'),
    'Create',
);

$this->menu=array(
	array('label'=>'Manage Vote', 'url'=>array('admin')),
);
?>
<h1>Hello, <?php echo Yii::app()->user->realName; ?>!</h1>

<h2>Own weight</h2>


<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'vote-grid',
	'dataProvider'=>$ownWeight,
	'filter'=>$ownWeight,
	'columns'=>array(
		'name', // category name
		'voteCount',
	),
)); ?>

<?php /* echo $this->renderPartial('_form', array('model'=>$model)); */ ?>
