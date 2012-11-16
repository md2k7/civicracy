<?php

$this->breadcrumbs=array(
    Yii::t('app', 'menu.vote') => array('/vote'),
	Yii::t('app', 'menu.categoryVote', array('{category}' => $category->name)),
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
			<h4><?php echo Yii::t('app', 'menu.categoryVoteUpdate', array('{category}' => $category->name)); ?></h4>
			<ul>
			<li><a class="btn btn-primary btn-civi btn-update-choice" href="<?php echo $this->createUrl('update', array('id' => $id)); ?>"><?php echo Yii::t('app', 'vote.delegate.button'); ?></a> <span class="buttonExpl"><strong>Ich kenne eine Person, die besser als ich entscheiden kann.</strong> Ich möchte derzeit nicht in den Rat.</span></li>
			<li><a class="btn btn-primary btn-civi btn-update-choice" href="<?php /* TODO */ echo $this->createUrl('update', array('id' => $id, 'remove' => 1)); ?>"><?php echo Yii::t('app', 'vote.selfreference.button'); ?></a> <span class="buttonExpl"><strong>Ich möchte Entscheidungen treffen.</strong> Ich kenne keine Person, der ich die Entscheidung überlassen würde.</span></li>
			<li><a class="btn btn-primary btn-civi btn-update-choice" href="<?php /* TODO */ echo $this->createUrl('update', array('id' => $id, 'remove' => 1)); ?>"><?php echo Yii::t('app', 'vote.remove.button'); ?></a> <span class="buttonExpl"><strong>Ich kenne keine Person, der ich die Entscheidung überlassen würde.</strong> Ich enthalte mich meiner Stimme und möchte derzeit nicht in den Rat.</span></li>
			</ul>
			<p class="space-top"><a class="btn btn-civi" href="<?php echo $this->createUrl('view', array('id' => $id)); ?>"><?php echo Yii::t('app', 'cancel.button'); ?></a> <span class="buttonExpl">Abbrechen und derzeitige Meinung beibehalten.</span></p>
		</div>
