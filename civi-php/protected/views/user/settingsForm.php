<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'user-form',
	'enableAjaxValidation'=>false,
)); ?>

	<?php echo Yii::t('app', 'forms.required'); ?>

	<?php echo $message; ?>
	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->label($model,'username'); ?>
		<p><?php echo CHtml::encode($model->username); ?></p>
	</div>

	<div class="row">
		<?php echo $form->label($model,'realname'); ?>
		<p><?php echo CHtml::encode($model->realname); ?></p>
	</div>

	<div class="row">
		<?php echo $form->label($model,'password'); ?>
		<p><?php echo Yii::t('app', 'models.password.description'); ?></p>
		<?php echo $form->passwordField($model,'password',array('size'=>60,'maxlength'=>128)); ?>
		<?php echo $form->error($model,'password'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'repeat_password'); ?>
		<?php echo $form->passwordField($model,'repeat_password',array('size'=>60,'maxlength'=>128)); ?>
		<?php echo $form->error($model,'repeat_password'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'email'); ?>
		<?php echo $form->textField($model,'email',array('size'=>60,'maxlength'=>128)); ?>
		<?php echo $form->error($model,'email'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'slogan'); ?>
		<p><?php echo Yii::t('app', 'models.slogan.description'); ?></p>
		<?php echo $form->textField($model,'slogan',array('class'=>'span12')); ?>
		<?php echo $form->error($model,'slogan'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton(Yii::t('app', 'user.save.button'), CiviGlobals::$buttonClass); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
