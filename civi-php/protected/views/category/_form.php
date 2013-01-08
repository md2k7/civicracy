<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'category-form',
	'enableAjaxValidation'=>false,
)); ?>

	<?php echo Yii::t('app', 'forms.required'); ?>

	<?php echo $form->errorSummary($model, NULL, NULL, CiviGlobals::$infoboxClass); ?>

	<div class="row">
		<?php echo $form->label($model,'institution'); ?>
		<?php echo $form->textField($model,'institution',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'institution'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'description'); ?>
		<?php echo $form->textField($model,'description',array('class'=>'span12')); ?>
		<?php echo $form->error($model,'description'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'boardsize'); ?>
		<?php echo $form->textField($model,'boardsize',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'boardsize'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'rmax'); ?>
		<?php echo $form->textField($model,'rmax',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'rmax'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'tmax'); ?>
		<?php echo $form->textField($model,'tmax',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'tmax'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model,'viewboard'); ?>
		<?php echo $form->checkBox($model,'viewboard'); ?>
		<?php echo $form->error($model,'viewboard'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'registrationcode'); ?>
		<p><?php echo Yii::t('app', 'models.registrationCode.description'); ?></p>
		<?php echo $form->textField($model,'registrationcode',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'registrationcode'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('app', 'category.create.button') : Yii::t('app', 'category.save.button'), CiviGlobals::$buttonClass); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
