<?php

$this->breadcrumbs=array(
    'Vote',
);

?>
<h1>Hello, <?php echo Yii::app()->user->realName; ?>!</h1>

<h2>Own weight</h2>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'own-votes-grid',
	'dataProvider'=>$ownWeight,
	'columns'=>array(
		'name', // category name
		'voteCount',
	),
)); ?>


<h2>Voted for</h2>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'voted-grid',
	'dataProvider'=>$votedFor,
	'columns'=>array(
		'name', // category name
		array(
			'header' => User::model()->getAttributeLabel('realname'),
			'value' => '$data->getCandidate()->realname',
		),
		array(
			'class' => 'CButtonColumn',
			'viewButtonUrl' => 'Yii::app()->urlManager->createUrl("view", array("columnId" => $data->id))',
		),
	),
)); ?>


<h2>Yet to vote for</h2>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'vote-grid',
	'dataProvider'=>$freeVote,
	'columns'=>array(
		'name', // category name
		array(
			'class' => 'CButtonColumn',
			'template' => '{update}',
		),
	),
)); ?>
