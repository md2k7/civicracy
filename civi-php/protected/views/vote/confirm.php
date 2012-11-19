<?php

$this->breadcrumbs=array(
    Yii::t('app', 'menu.vote') => array('/vote'),
    Yii::t('app', 'menu.confirmCategoryVote', array('{category}' => $category->name)),
);

$this->menu=array(
	array('label' => Yii::t('app', 'menu.vote.again'), 'url'=>array('update', 'id' => $id)),
);

?>
		<?php echo $this->renderPartial('heroUnit', array('category' => $category)); ?>
		<div class="main-content">
			<div class="responsibility">
				<h4><?php echo Yii::t('app', 'vote.ownWeight'); ?></h4>
				<div class="responsibility-number"><?php echo CHtml::encode($weight); ?></div>
				<img src="<?php echo Yii::app()->request->baseUrl; ?>/img/responsibility.png" alt="<?php echo Yii::t('app', 'vote.ownWeight'); ?>" />
			</div>

			<?php echo $this->renderPartial('confirm' . ucfirst($type), array('category' => $category, 'candidate' => $candidate, 'votePath' => $votePath, 'model' => $model, 'weight' => $weight, 'nextVoteTime' => $nextVoteTime, 'leaveBoard' => $leaveBoard)); ?>

			<div class="form">
				<?php $form=$this->beginWidget('CActiveForm', array(
					'id'=>'vote-form',
					'enableAjaxValidation'=>false,
					'action'=>$this->createUrl('confirm', array('id' => $id, 'type' => $type)),
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
						<?php echo CHtml::submitButton(Yii::t('app', "vote.$type.button"), CMap::mergeArray(CiviGlobals::$buttonClassWarning, array('name' => 'confirm', 'style' => 'margin-bottom: 1px;'))); ?> <a class="btn btn-civi" href="<?php echo $this->createUrl('view', array('id' => $id)); ?>"><?php echo Yii::t('app', 'cancel.button'); ?></a>
				</div>
				<?php $this->endWidget(); ?>
			</div>
		</div>
