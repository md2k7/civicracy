<?php

/**
 * Confirm vote revocation sub-view.
 *
 * @param Category $category the current category we are viewing
 * @param string $candidate real name of the candidate to confirm vote delegation for (TODO: use model)
 * @param Vote $model the current Vote we are confirming (not yet used)
 * @param array $votePath array of vote elements, each with realname, slogan, candidate_id, reason
 * @param boolean $leaveBoard whether to display warning that user is leaving the board
 */

?>
			<h4><?php echo Yii::t('app', 'menu.categoryVoteRevoke', array('{category}' => $category->name, '{candidate}' => $candidate)); ?></h4>
			<p>Du bist dabei, deine <?php echo CHtml::encode($category->name); ?>-Stimme zurückzunehmen.</p>

			<div class="container">
				<?php echo $this->renderPartial('_path', array('votePath'=>$votePath, 'noSloganChange' => true)); ?>
			</div>

			<div class="alert alert-red space-top">
				<p>Bist Du sicher, dass Du keine bessere Person kennst?</p>
				<?php if($leaveBoard) { echo Yii::t('app', 'vote.warning.leaveBoard'); } ?>
			</div>
