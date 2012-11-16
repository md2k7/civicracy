<?php

$this->breadcrumbs=array(
    Yii::t('app', 'menu.vote') => array('/vote'),
    Yii::t('app', 'menu.viewCategoryVote', array('{category}' => $category->name)),
);

$this->menu=array(
	array('label' => Yii::t('app', 'menu.vote.again'), 'url'=>array('update', 'id' => $id)),
);

?>
		<div class="hero-unit">
			<div class="hero-left">
				<div class="hero-title">
					<h1><?php echo CHtml::encode(Yii::app()->name); ?></h1>
					<p><?php echo Yii::t('app', 'site.motto'); ?></p>
				</div>
				<div class="hero-logo">
					<img src="<?php echo Yii::app()->request->baseUrl; ?>/img/civicracy.png" alt="Kreise" />
				</div>
			</div>
			<div class="hero-right hero-title-right">
				<h2><?php echo CHtml::encode($category->institution); ?></h2>
				<h3><?php echo CHtml::encode($category->name); ?></h3>
				<div class="hero-description">
					<p><?php echo CHtml::encode($category->description); ?></p>
				</div>
			</div>
			<div class="container"></div>
		</div>
		<div class="main-content">
		
			<div class="row">
				<div class="span5">
					<h4><?php echo Yii::t('app', 'vote.path'); ?></h4>
					<?php echo $this->renderPartial('_path', array('votePath'=>$votePath)); ?>
					<br><br>
					<div id="voteButtonPanel"<?php if(!$mayVote) { echo ' style="display: none;"'; } ?>>
						<p><?php if($voted) { ?><a class="btn btn-primary btn-civi" href="<?php echo $this->createUrl('update', array('id' => $id, 'remove' => 1)); ?>"><?php echo Yii::t('app', 'vote.remove.button'); ?></a> <?php } ?><a class="btn btn-primary btn-civi" href="<?php echo $this->createUrl('update', array('id' => $id)); ?>"><?php echo Yii::t('app', $voted ? 'vote.update.button' : 'vote.button'); ?></a></p>
					</div>
				</div>
				<div class="span4" align="center">
					<?php 
					if($category->viewboard == true)
					{?>
					
					
						<h4><?php echo Yii::t('app', 'vote.currentlyresult'); ?></h4>
	
						<br>
							
						<table class="table table-striped">
			 				<tr>
				 				<th><?php echo Yii::t('app', 'voteresult.name'); ?></th>
				 				<th><?php echo Yii::t('app', 'voteresult.slogan'); ?></th>
				 			</tr>
			 				
			 				<?php 
								for($i=0; $i<count($ranking); $i++)
									echo '<tr><td>'.CHtml::encode($ranking[$i]['realname']).'</td> <td>'.CHtml::encode($ranking[$i]['slogan']).'</td> </tr>';
							?>
						</table> 
					<?php 
					}?>
				</div>
				<div class="span1" align="center">
				
				</div>
  				<div class="span2">
  					<h4><?php echo Yii::t('app', 'vote.ownWeight'); ?></h4>
					<div class="responsibility-number"><?php echo CHtml::encode($weight); ?></div>
					<img src="<?php echo Yii::app()->request->baseUrl; ?>/img/responsibility.png" alt="<?php echo Yii::t('app', 'vote.ownWeight'); ?>" />
  				</div>
			</div>
			<?php if(!$mayVote) { ?>
			<div id="countdownPanel">
				<h4>Zeit bis zur erneuten Stimmabgabe</h4>
				<p>Du hast am <?php echo date(Yii::t('app', 'timestamp.format'), $votedTime); ?> abgestimmt. Du kannst Deine Stimme voraussichtlich ab <?php echo date(Yii::t('app', 'timestamp.format'), $nextVoteTime); ?> wieder ändern.</p>
				<div class="progress">
					<div id="elapsed" class="bar bar-success" style="width: 0%;"></div><div id="remaining" class="bar" style="width: 0%;"></div>
				</div>
			</div>
			<?php } ?>
		</div>
<?php

// include js/countdown.js
CiviGlobals::requireJs('countdown.js');

?>
<script type="text/javascript">
	$(document).ready(function() {
		var from = new Date(<?php echo date('Y, ', $votedTime) . (((int)date('m', $votedTime))-1) . date(', j, G, ', $votedTime) . ((int)date('i', $votedTime)) . ', ' . ((int)date('s', $votedTime)); ?>);
		var target = new Date(<?php echo date('Y, ', $nextVoteTime) . (((int)date('m', $nextVoteTime))-1) . date(', j, G, ', $nextVoteTime) . ((int)date('i', $nextVoteTime)) . ', ' . ((int)date('s', $nextVoteTime)); ?>);
		var days = '<?php echo Yii::t('app', 'vote.days'); ?>';
		var remaining = '<?php echo Yii::t('app', 'vote.remaining'); ?>';
		
		$(".progress").countdown(from, target, days, remaining);
	});
</script>
