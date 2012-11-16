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
		'institution',
		'name',
		'description',
		'boardsize',
		'rmax',
		'tmax',
	),
)); ?>
		</div>
		<?php $boardsize = count($ranking); ?>

		<br>
		<br>
		
		<div class="row">		
			<div class="span4" align="center">
				<h4><?php echo Yii::t('app', 'vote.participation')?></h4>
				<div 
				<?php 
					if($voteparticipation > 60)
						echo ' class="progress progress-success"';
					elseif($voteparticipation > 30)
						echo ' class="progress progress-warning"';
					else
						echo ' class="progress progress-danger"';
				?>
				>
					<?php  
					
						if($voteparticipation >= 10)
							echo '<div class="bar" style="width: '.$voteparticipation.'%;"> '.$voteparticipation.' % </div>';
						else
							echo $voteparticipation.' % <div class="bar" style="width: '.$voteparticipation.'%;"> </div>';
					?>
  					
				</div>
				<?php if(!$ranking===false) { ?>
				<?php
				$pievalues=$ranking[0]['weight'];
					for($i=1; $i<count($ranking); $i++)
						$pievalues.='*'.$ranking[$i]['weight'];
				?>
				<br>
				<h4><?php echo Yii::t('app', 'vote.currentlyresult')?></h4>
				<img src="<?php echo Yii::app()->request->baseUrl; ?>/img/piechart.php?data=<?php echo $pievalues; ?>">
				
				<br><br>
				
				<a class="btn btn-primary btn-civi" href="<?php echo $this->createUrl('contact', array('categoryId' => $model->id, 'target' => 'board')); ?>"><?php echo Yii::t('app', 'category.board').' '.Yii::t('app', 'category.send'); ?></a>
				<a class="btn btn-primary btn-civi" href="<?php echo $this->createUrl('contact', array('categoryId' => $model->id, 'target' => 'all')); ?>"><?php echo Yii::t('app', 'category.all').' '.Yii::t('app', 'category.send'); ?></a>
			</div>
		
			<div class="span8" align="center">
				<h4><?php echo Yii::t('app', 'vote.currentlyresult')?></h4>
				
				<table class="table table-striped">
		 				<tr>
		 					<th> </th>
		 					<th><?php echo Yii::t('app', 'voteresult.rank'); ?></th>
			 				<th><?php echo Yii::t('app', 'voteresult.name'); ?></th>
			 				<th><?php echo Yii::t('app', 'voteresult.weightAbs'); ?></th>
			 				<th><?php echo Yii::t('app', 'voteresult.weightPerBoard'); ?></th>
			 				<th><?php echo Yii::t('app', 'voteresult.weightPerAll'); ?></th>
			 				<th><?php echo Yii::t('app', 'voteresult.slogan'); ?></th>
			 			</tr>
		 				
		 				
		 				
		 				<?php 
							for($i=0; $i<$boardsize; $i++)
							{
								echo '<tr> <td> <img src="'.Yii::app()->request->baseUrl.'/img/rectangle.php?data='.($i).'"> </td> <td>'.($i+1).'</td> <td>'.CHtml::encode($ranking[$i]['realname']).'</td> <td>'.CHtml::encode($ranking[$i]['weight']).'</td> <td>'.CHtml::encode($ranking[$i]['percentBoard'].'%').'</td> <td>'.CHtml::encode($ranking[$i]['percentUsers'].'%').'</td> <td>'.CHtml::encode($ranking[$i]['slogan']).'</td> </tr>';
							}
						?>
					</table> 
			</div>
			<?php }?>
		</div>
		
