<?php

$this->breadcrumbs=array(
    'Vote'=>array('/vote'),
    'View',
);

$this->menu=array(
	array('label'=>'Vote', 'url'=>array('index')),
);

?>
<h1>History of my vote</h1>
<p>Category: <?php /* TODO */ ?></p>

<?php /*<p>VOTE AGAIN button TODO</p>*/ ?>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'vote-history-grid',
	'dataProvider'=>$voteHistory,
	'columns'=>array(
		'realname',
	),
)); ?>
