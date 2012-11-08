<?php
$this->breadcrumbs=array(
	Yii::t('app', 'menu.categories') => array('admin'),
	$model->name,
);

$this->menu=array(
	array('label' => Yii::t('app', 'menu.categories.create'), 'url'=>array('create')),
	array('label' => Yii::t('app', 'menu.categories.update'), 'url'=>array('update', 'id'=>$model->id)),
	array('label' => Yii::t('app', 'menu.categories.delete'), 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'))),
	array('label' => Yii::t('app', 'menu.categories.manageAll'), 'url'=>array('admin')),
);
?>
		<div class="main-content">
<h1><?php echo Yii::t('app', 'menu.category', array('{category}' => $model->name)); ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'name',
		'description',
		'boardsize',
	),
)); ?>
		</div>
		
		<div class="main-content" align="center">
			<p><h4><?php echo Yii::t('app', 'vote.currentlyresult'); ?></h4></p>
		</div>
		
		<div class="row">
			<?php $boardsize = count($ranking); ?>
		
			<div class="span4">
				<?php 
					$pievalues=$ranking[0]['weight'];
					for($i=1; $i<$boardsize; $i++)
						$pievalues.='*'.$ranking[$i]['weight'];
				?>
			
				<img src= "<?php echo Yii::app()->request->baseUrl; ?> /img/piechart.php?data= <?php echo $pievalues; ?>">
			</div>
		
			<div class="span8">
				<table class="table table-striped">
		 				<tr>
		 					<th><?php echo Yii::t('app', 'voteresult.rank'); ?></th>
			 				<th><?php echo Yii::t('app', 'voteresult.name'); ?></th>
			 				<th><?php echo Yii::t('app', 'voteresult.weightAbs'); ?></th>
			 				<th><?php echo Yii::t('app', 'voteresult.weightPer'); ?></th>
			 				<th><?php echo Yii::t('app', 'voteresult.slogan'); ?></th>
			 			</tr>
		 				
		 				<?php 
							for($i=0; $i<$boardsize; $i++)
								echo '<tr> <td>'.($i+1).'</td> <td>'.$ranking[$i]['realname'].'</td> <td>'.$ranking[$i]['weight'].'</td> <td> </td> <td>'.$ranking[$i]['slogan'].'</td> </tr>';
						?>
					</table> 
			</div>
		</div>