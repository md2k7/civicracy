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
		<p><?php echo CHtml::escape($model->username); ?></p>
	</div>

	<div class="row">
		<?php echo $form->label($model,'realname'); ?>
		<p><?php echo CHtml::escape($model->realname); ?></p>
	</div>

	<div class="row">
		<?php echo $form->label($model,'password'); ?>
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

	<div class="row buttons">
		<?php echo CHtml::submitButton(Yii::t('app', 'user.save.button')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
