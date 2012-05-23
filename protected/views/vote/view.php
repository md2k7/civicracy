<?php

$this->breadcrumbs=array(
    Yii::t('app', 'Vote') => array('/vote'),
    Yii::t('app', 'View {category} Vote', array('{category}' => $category)),
);

$this->menu=array(
	array('label' => Yii::t('app', 'Vote again'), 'url'=>array('update', 'id' => $id)),
);

?>
<h1><?php echo Yii::t('app', 'History of my vote'); ?></h1>
<p><?php echo Category::model()->getAttributeLabel('name'); ?>: <strong><?php echo $category; ?></strong><br/>
<?php echo Vote::model()->getAttributeLabel('reason'); ?>: <strong><?php echo $reason; ?></strong></p>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'vote-history-grid',
	'dataProvider'=>$voteHistory,
	'columns'=>array(
		array(
			'header' => User::model()->getAttributeLabel('realname'),
			'value' => '$data->realname',
		),
		array(
			'header' => Vote::model()->getAttributeLabel('reason'),
			'value' => '$data->reason',
		),
	),
)); ?>
