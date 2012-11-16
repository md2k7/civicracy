<?php

$this->breadcrumbs=array(
    Yii::t('app', 'menu.vote') => array('/vote'),
    Yii::t('app', 'menu.confirmCategoryVote', array('{category}' => $category->name)),
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
			<div class="responsibility">
				<h4><?php echo Yii::t('app', 'vote.ownWeight'); ?></h4>
				<div class="responsibility-number"><?php echo CHtml::encode($weight); ?></div>
				<img src="<?php echo Yii::app()->request->baseUrl; ?>/img/responsibility.png" alt="<?php echo Yii::t('app', 'vote.ownWeight'); ?>" />
			</div>

			<h4><?php echo Yii::t('app', $revoke ? 'menu.categoryVoteRevoke' : 'menu.categoryVoteFor', array('{category}' => $category->name, '{candidate}' => $candidate)); ?></h4>

			<?php if($revoke) { ?>
			<p>Du bist dabei, deine <?php echo CHtml::encode($category->name); ?>-Stimme zurückzunehmen.</p>
			<?php } else { ?>
			<p>Du bist dabei, deine <?php echo CHtml::encode($category->name); ?>-Stimme für <strong><?php echo CHtml::encode($candidate); ?></strong> abzugeben. Damit bekommt diese Person zusätzlich Deine gesamte Verantwortung (aktuell <strong><?php echo CHtml::encode($weight); ?></strong>).</p>
			<p><em>Deine Begründung:</em> <strong><?php echo CHtml::encode($model->reason); ?></strong></p>
			<p>Personen, die Dich wählen, können Deine Wahl und Begründung in ihrem Stimmenverlauf sehen.</p>
			<?php } ?>

			<div class="container">
				<?php echo $this->renderPartial('_path', array('votePath'=>$votePath, 'noSloganChange' => true)); ?>
			</div>

			<div class="alert alert-red space-top">
				<?php if($revoke) { ?>
				<p>Bist Du sicher, dass Du die beste Person bist?</p>
				<?php } else { ?>
				<p>Die jetzt abgegebene Stimme wirst Du voraussichtlich ab <strong><?php echo CHtml::encode(date(Yii::t('app', 'timestamp.format'), $nextVoteTime)); ?> wieder ändern</strong> können. Bist Du sicher, dass Du richtig gestimmt hast?</p>
				<?php } ?>
			</div>
			<div class="form">
				<?php $form=$this->beginWidget('CActiveForm', array(
					'id'=>'vote-form',
					'enableAjaxValidation'=>false,
				)); ?>
				<div>
					<?php echo $form->label($model,'password'); ?>
					<p>Bitte gib zum Abstimmen Dein aktuelles Passwort ein.</p>
					<?php echo $form->passwordField($model,'password',array('size'=>60,'maxlength'=>128)); ?>
					<?php echo $form->error($model,'password'); ?>
				</div>
				<div class="buttons">
						<?php echo $form->hiddenField($model,'category_id'); ?>
						<?php echo $form->hiddenField($model,'candidate_id',array('name'=>'candidate','value'=>$candidate)); ?>
						<?php echo $form->hiddenField($model,'reason'); ?>
						<?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('app', 'vote.button') : Yii::t('app', $revoke ? 'vote.remove.button' : 'vote.button'), CMap::mergeArray(CiviGlobals::$buttonClassWarning, array('name' => 'confirm'))); ?> <?php echo CHtml::submitButton(Yii::t('app', 'cancel.button'), CMap::mergeArray(CiviGlobals::$buttonClassCancel, array('name' => 'cancel'))); ?> 
				</div>
				<?php $this->endWidget(); ?>
			</div>
		</div>
