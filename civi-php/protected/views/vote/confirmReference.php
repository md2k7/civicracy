<?php

/**
 * Confirm vote self-reference sub-view.
 *
 * @param Category $category the current category we are viewing
 * @param string $candidate real name of the candidate to confirm vote delegation for (TODO: use model)
 * @param Vote $model the current Vote we are confirming (not yet used)
 * @param int $nextVoteTime unix timestamp of the prediction of the next time user can change the vote
 * @param array $votePath array of vote elements, each with realname, slogan, candidate_id, reason
 */

?>
			<h4><?php echo Yii::t('app', 'menu.categoryVoteReference', array('{category}' => $category->name, '{candidate}' => $candidate)); ?></h4>
			<p>Du bist dabei, deine <?php echo CHtml::encode($category->name); ?>-Stimme Dir selbst zu geben. Bitte denke daran, nach dieser Bestätigung in deinem Benutzerprofil (Menüpunkt "Einstellungen") unter "Slogan" zu begründen, warum Du für den Rat geeignet bist!</p>

			<div class="container">
				<?php echo $this->renderPartial('_path', array('votePath'=>$votePath, 'noSloganChange' => true)); ?>
			</div>

			<div class="alert alert-red space-top">
				<p>Du kandidierst für den Rat. Das wirst Du voraussichtlich ab <strong><?php echo CHtml::encode(date(Yii::t('app', 'timestamp.format'), $nextVoteTime)); ?> wieder ändern</strong> können. Bist Du sicher, dass Du die beste Person bist?</p>
			</div>
