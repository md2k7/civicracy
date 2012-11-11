<?php

/**
 * Graphical display of vote path - shows where the user's vote is being delegated to
 *
 * @param array $votePath array of vote elements, each with realname, slogan, candidate_id, reason
 * @param boolean $noSloganChange optional to hide slogan-change button
 */

 
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
			if ($vote->candidate_id == Yii::app()->user->id && (!isset($noSloganChange) || $noSloganChange === false))
			{ 
				echo "<a class='label label-info' href=".$this->createUrl('user/settings').">".Yii::t('app','vote.changeslogan.button')."</a>"; 
			}
			?> 
		</p>
		<?php /* display reason why user votes for him/herself. No nice formatting yet, and slogan fits nicely anyway. */ /* if($vote == end($votePath)) { ?>
		<p><?php echo $vote->reason; ?></p>
		<?php } */ ?>
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