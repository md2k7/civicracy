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
				<h2>HTL Rennweg</h2>
				<h3><?php echo $category->name; ?></h3>
				<div class="hero-description">
					<p><?php echo $category->description; ?></p>
				</div>
			</div>
			<div class="container"></div>
		</div>
		<div class="main-content">
		
			<div class="row">
				<div class="span5">
					<h4><?php echo Yii::t('app', 'vote.path'); ?></h4>
					<?php echo $this->renderPartial('_path', array('votePath'=>$votePath)); ?>
				</div>
				<div class="span4" align="center">
					
					<?php $boardsize = count($ranking)?>	
					
					<h4><?php echo Yii::t('app', 'vote.currentlyresult').$boardsize; ?></h4>
				
					<?php 
						$pievalues=$ranking[0]['weight'];
						for($i=1; $i<$boardsize; $i++)
							$pievalues.='*'.$ranking[$i]['weight'];
					?>
					
					<br>
						
					<table class="table table-striped">
		 				<tr>
			 				<th><?php echo Yii::t('app', 'voteresult.name'); ?></th>
			 				<th><?php echo Yii::t('app', 'voteresult.slogan'); ?></th>
			 			</tr>
		 				
		 				<?php 
							for($i=0; $i<$boardsize; $i++)
								echo '<tr><td>'.$ranking[$i]['realname'].'</td> <td>'.$ranking[$i]['slogan'].'</td> </tr>';
						?>
					</table> 
				</div>
				<div class="span1" align="center">
				
				</div>
  				<div class="span2">
  					<h4><?php echo Yii::t('app', 'vote.ownWeight'); ?></h4>
					<div class="responsibility-number"><?php echo $weight; ?></div>
					<img src="<?php echo Yii::app()->request->baseUrl; ?>/img/responsibility.png" alt="<?php echo Yii::t('app', 'vote.ownWeight'); ?>" />
  				</div>
			</div>

			<div id="voteButtonPanel"<?php if(!$mayVote) { echo ' style="display: none;"'; } ?>>
				<p><?php if($voted) { ?><a class="btn btn-primary btn-civi" href="<?php echo $this->createUrl('update', array('id' => $id, 'remove' => 1)); ?>"><?php echo Yii::t('app', 'vote.remove.button'); ?></a> <?php } ?><a class="btn btn-primary btn-civi" href="<?php echo $this->createUrl('update', array('id' => $id)); ?>"><?php echo Yii::t('app', $voted ? 'vote.update.button' : 'vote.button'); ?></a></p>
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
<script type="text/javascript">
(function ($) {
	$.fn.countdown = function () {
		var from = new Date(<?php echo date('Y, ', $votedTime) . (((int)date('m', $votedTime))-1) . date(', j, G, ', $votedTime) . ((int)date('i', $votedTime)) . ', ' . ((int)date('s', $votedTime)); ?>);
		var target = new Date(<?php echo date('Y, ', $nextVoteTime) . (((int)date('m', $nextVoteTime))-1) . date(', j, G, ', $nextVoteTime) . ((int)date('i', $nextVoteTime)) . ', ' . ((int)date('s', $nextVoteTime)); ?>);
		var days = '<?php echo Yii::t('app', 'vote.days'); ?>';
		var remaining = '<?php echo Yii::t('app', 'vote.remaining'); ?>';

		function pad(num, size) {
			var s = num + '';
			while(s.length < size)
				s = '0' + s;
			return s;
		}

		function refreshCountdown() {
			curDate = new Date();
			diff = Math.floor((target - curDate) / 1000);
			if(diff < 0) {
				$('#voteButtonPanel').show();
				$('#countdownPanel').hide();
			} else {
				delta = '';

				// seconds
				delta = pad(diff % 60, 2) + delta;
				diff = Math.floor(diff / 60);

				// minutes
				delta = pad(diff % 60, 2) + ':' + delta;
				diff = Math.floor(diff / 60);

				// hours
				delta = pad(diff % 24, 2) + ':' + delta;
				diff = Math.floor(diff / 24);

				if(diff > 0) {
					// days
					delta = diff + ' ' + days + ', ' + delta;
				}

				dur = target - from;
				cur = target - curDate;
				perc = (cur * 100) / dur;
				$('#elapsed').css('width', (100 - perc).toFixed(2) + '%');
				$('#remaining').css('width', perc.toFixed(2) + '%');

				if(perc > 50) {
					$('#elapsed').html('');
					$('#remaining').html(delta + ' ' + remaining);
				} else {
					$('#elapsed').html(delta + ' ' + remaining);
					$('#remaining').html('');
				}
			}
		}

		setInterval(refreshCountdown, 1000);
	};
})(jQuery);

$(document).ready(function() {
	$(".progress").countdown();
});
</script>