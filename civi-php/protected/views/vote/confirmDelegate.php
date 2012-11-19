<?php

/**
 * Confirm vote delegation sub-view.
 *
 * @param Category $category the current category we are viewing
 * @param string $candidate real name of the candidate to confirm vote delegation for (TODO: use model)
 * @param Vote $model the current Vote we are confirming
 * @param int $nextVoteTime unix timestamp of the prediction of the next time user can change the vote
 * @param array $votePath array of vote elements, each with realname, slogan, candidate_id, reason
 * @param boolean $leaveBoard whether to display warning that user is leaving the board
 */

?>
			<h4><?php echo Yii::t('app', 'menu.categoryVoteFor', array('{category}' => $category->name, '{candidate}' => $candidate)); ?></h4>

			<p>Du bist dabei, deine <?php echo CHtml::encode($category->name); ?>-Stimme für <strong><?php echo CHtml::encode($candidate); ?></strong> abzugeben. Damit bekommt diese Person zusätzlich Deine gesamte Verantwortung (aktuell <strong><?php echo CHtml::encode($weight); ?></strong>).</p>
			<p><em>Deine Begründung:</em> <strong><?php echo CHtml::encode($model->reason); ?></strong></p>
			<p>Personen, die Dich wählen, können Deine Wahl und Begründung in ihrem Stimmenverlauf sehen.</p>

			<div class="container">
				<?php echo $this->renderPartial('_path', array('votePath'=>$votePath, 'noSloganChange' => true)); ?>
			</div>

			<div class="alert alert-red space-top">
				<p>Die jetzt abgegebene Stimme wirst Du voraussichtlich ab <strong><?php echo CHtml::encode(date(Yii::t('app', 'timestamp.format'), $nextVoteTime)); ?> wieder ändern</strong> können. Bist Du sicher, dass Du richtig gestimmt hast?</p>
				<?php if($leaveBoard) { echo Yii::t('app', 'vote.warning.leaveBoard'); } ?>
			</div>
