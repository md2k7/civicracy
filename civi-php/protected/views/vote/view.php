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
					<?php 
						foreach($votePath as $vote) 
						{ ?>
							<div class="vp-row">
								<div class="vp-left">
									<img src="<?php echo Yii::app()->request->baseUrl; ?>/img/user_arrows.png" alt="User" />
								</div>
								<div class="vp-right">
									<h5><?php echo $vote->realname; ?></h5>
									<p>
								       <?php 
								        echo $vote->slogan == '' ? Yii::t('app', 'vote.noslogan') : $vote->slogan; 
								        echo " "; 
								        if ($vote->candidate_id == Yii::app()->user->id) 
								        { 
								         echo "<a class='label label-info' href=".$this->createUrl('user/settings', array('id' => $id)).">".Yii::t('app','vote.changeslogan.button')."</a>"; 
								        }
								       ?> 
								    </p>
								</div>
							</div>
							<?php if($vote !== end($votePath)) 
							{ ?>
								<div class="vp-row vp-row-arrow">
									<div class="vp-left">
										<img src="<?php echo Yii::app()->request->baseUrl; ?>/img/arrow.png" alt="delegiert" />
									</div>
									<div class="vp-right"><?php echo $vote->reason; ?></div>
								</div>
							<?php 
						} } ?>
				</div>
				<div class="span4" align="center">
					<h4> <?php echo Yii::t('app', 'vote.currentlyresult'); ?> <br> </h4>
					<br />			
					<table class="table table-striped">
		 				<tr>
		 					<th><?php echo Yii::t('app', 'voteresult.rank'); ?></th>
			 				<th><?php echo Yii::t('app', 'voteresult.name'); ?></th>
			 				<th><?php echo Yii::t('app', 'voteresult.weightAbs'); ?></th>
			 				<th><?php echo Yii::t('app', 'voteresult.weightPer'); ?></th>
			 			</tr>
		 				
		 				<?php 
							for($i=0; $i<count($ranking); $i++)
								echo '<tr><td>'.($i+1).'</td> <td>'.$ranking[$i]['realname'].'</td> <td>'.$ranking[$i]['weight'].'</td> <td>'.'</td> </tr>';
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
		
		
			
			
			
			<div class="container">
				
				<p>&nbsp;</p>
			</div>
			<p><a class="btn btn-primary btn-civi" href="<?php echo $this->createUrl('update', array('id' => $id)); ?>"><?php echo Yii::t('app', $voted ? 'vote.update.button' : 'vote.button'); ?></a></p>
			<h4>Zeit bis zur erneuten Stimmabgabe (DRAFT - work in progress)</h4>
			<p>delta T = <?php echo $deltaT; ?></p>
			<p>Sie haben am <?php echo date(Yii::t('app', 'timestamp.format'), $votedTime); ?> abgestimmt. Sie können Ihre Stimme voraussichtlich ab <?php echo date(Yii::t('app', 'timestamp.format'), $nextVoteTime); ?> wieder ändern.</p>
			<div class="progress">
				<div id="elapsed" class="bar bar-success" style="width: 0%;"></div><div id="remaining" class="bar" style="width: 0%;"></div>
			</div>
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
				$('#remaining').html('');
				$('#elapsed').html('00:00:00');
				$('#elapsed').css('width', '100%');
				$('#remaining').css('width', '0%');
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