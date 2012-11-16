<?php

$this->breadcrumbs=array(
    Yii::t('app', 'menu.vote') => array('/vote'),
	Yii::t('app', 'menu.categoryVote', array('{category}' => $category->name)),
);

?>
		<?php echo $this->renderPartial('heroUnit', array('category' => $category)); ?>
		<div class="main-content">
			<h4><?php echo Yii::t('app', 'menu.categoryVoteUpdate', array('{category}' => $category->name)); ?></h4>
			<ul>
			<li><a class="btn btn-primary btn-civi btn-update-choice" href="<?php echo $this->createUrl('update', array('id' => $id)); ?>"><?php echo Yii::t('app', 'vote.delegate.button'); ?></a> <span class="buttonExpl"><strong>Ich kenne eine Person, die besser als ich entscheiden kann.</strong> Ich möchte derzeit nicht in den Rat.</span></li>
			<li><a class="btn btn-primary btn-civi btn-update-choice" href="<?php /* TODO */ echo $this->createUrl('update', array('id' => $id, 'remove' => 1)); ?>"><?php echo Yii::t('app', 'vote.selfreference.button'); ?></a> <span class="buttonExpl"><strong>Ich möchte Entscheidungen treffen.</strong> Ich kenne keine Person, der ich die Entscheidung überlassen würde.</span></li>
			<li><a class="btn btn-primary btn-civi btn-update-choice" href="<?php /* TODO */ echo $this->createUrl('update', array('id' => $id, 'remove' => 1)); ?>"><?php echo Yii::t('app', 'vote.remove.button'); ?></a> <span class="buttonExpl"><strong>Ich kenne keine Person, der ich die Entscheidung überlassen würde.</strong> Ich enthalte mich meiner Stimme und möchte derzeit nicht in den Rat.</span></li>
			</ul>
			<p class="space-top"><a class="btn btn-civi" href="<?php echo $this->createUrl('view', array('id' => $id)); ?>"><?php echo Yii::t('app', 'cancel.button'); ?></a> <span class="buttonExpl">Abbrechen und derzeitige Meinung beibehalten.</span></p>
		</div>
