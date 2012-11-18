<?php

$this->breadcrumbs=array(
    Yii::t('app', 'menu.vote') => array('/vote'),
	Yii::t('app', 'menu.categoryVote', array('{category}' => $category->name)),
);

?>
		<?php echo $this->renderPartial('heroUnit', array('category' => $category)); ?>
		<div class="main-content">
			<h4><?php echo Yii::t('app', 'menu.categoryVoteUpdate', array('{category}' => $category->name)); ?></h4>
			<ul class="update-choice">
			<li><a class="<?php echo CiviGlobals::$buttonClass['class']; ?> btn-success btn-large btn-update-choice" href="<?php echo $this->createUrl('delegate', array('id' => $id)); ?>"><?php echo Yii::t('app', 'vote.delegate.button'); ?></a> <span class="buttonExpl"><strong>Ich kenne eine Person, die besser als ich entscheiden kann.</strong> Ich möchte derzeit nicht in den Rat.</span></li>
			<li><a class="<?php echo CiviGlobals::$buttonClassWarning['class']; ?> btn-large btn-update-choice" href="<?php echo $this->createUrl('reference', array('id' => $id)); ?>"><?php echo Yii::t('app', 'vote.reference.button'); ?></a> <span class="buttonExpl"><strong>Ich möchte Entscheidungen treffen.</strong> Ich kenne keine Person, der ich die Entscheidung überlassen würde.</span></li>
			<li><a class="<?php echo CiviGlobals::$buttonClassDanger['class']; ?> btn-large btn-update-choice" href="<?php echo $this->createUrl('revoke', array('id' => $id)); ?>"><?php echo Yii::t('app', 'vote.revoke.button'); ?></a> <span class="buttonExpl"><strong>Ich kenne keine Person, der ich die Entscheidung überlassen würde.</strong> Ich enthalte mich meiner Stimme und möchte derzeit nicht in den Rat.</span></li>
			</ul>
			<p class="space-top"><a class="btn btn-civi" href="<?php echo $this->createUrl('view', array('id' => $id)); ?>"><?php echo Yii::t('app', 'cancel.button'); ?></a> <span class="buttonExpl">Abbrechen und derzeitige Stimme beibehalten.</span></p>
		</div>
