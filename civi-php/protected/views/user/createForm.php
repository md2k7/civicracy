<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'user-form',
	'enableAjaxValidation'=>false,
)); ?>

	<?php echo Yii::t('app', 'forms.required'); ?>

	<?php echo $form->errorSummary($model, NULL, NULL, CiviGlobals::$infoboxClass); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'username'); ?>
		<?php echo $form->textField($model,'username',array('size'=>60,'maxlength'=>128)); ?>
		<?php echo $form->error($model,'username'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'realname'); ?>
		<?php echo $form->textField($model,'realname',array('size'=>60,'maxlength'=>128)); ?>
		<?php echo $form->error($model,'realname'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'email'); ?>
		<?php echo $form->textField($model,'email',array('size'=>60,'maxlength'=>128)); ?>
		<?php echo $form->error($model,'email'); ?>
		<?php echo Yii::t('app', 'user.registration.email'); ?>
	</div>

<?php if(!(property_exists(Yii::app()->user, 'isAdmin') && Yii::app()->user->isAdmin)): ?>
	<div class="row">
		<?php echo $form->labelEx($model,'registrationCode'); ?>
		<?php echo $form->textField($model,'registrationCode',array('size'=>60,'maxlength'=>128)); ?>
		<?php echo $form->error($model,'registrationCode'); ?>
	</div>
<?php endif; ?>

	<div class="row buttons">
		<?php echo CHtml::submitButton(Yii::t('app', 'user.create.button'), CiviGlobals::$buttonClass); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
