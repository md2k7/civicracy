<?php

$this->breadcrumbs=array(
    'Vote'=>array('/vote'),
    'View '.$category,
);

$this->menu=array(
	array('label'=>'Vote again', 'url'=>array('update', 'id' => $id)),
);

?>
<h1>History of my vote</h1>
<p>Category: <strong><?php echo $category; ?></strong></p>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'vote-history-grid',
	'dataProvider'=>$voteHistory,
	'columns'=>array(
		array(
			'header' => User::model()->getAttributeLabel('realname'),
			'value' => '$data->realname',
		),
	),
)); ?>
