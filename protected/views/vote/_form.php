<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'vote-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($categoryModel,'name'); ?>
		<p><?php echo $categoryModel->name; ?></p>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'candidate_id'); ?>
		<?php echo $form->textField($model,'candidate_id',array('size'=>60,'maxlength'=>128)); ?>
		<?php echo $form->error($model,'candidate_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'reason'); ?>
		<?php echo $form->textField($model,'reason',array('size'=>60,'maxlength'=>128)); ?>
		<?php echo $form->error($model,'reason'); ?>
	</div>
	<?php echo $form->hiddenField($model,'category_id'); ?>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Vote' : 'Update vote'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
