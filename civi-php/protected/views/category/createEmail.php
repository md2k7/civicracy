<?php
$this->breadcrumbs=array(
		Yii::t('app', 'menu.categories') => array('admin'),
);
?>
<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
		'id'=>'createEmail_form',
		'enableAjaxValidation'=>false,
)); ?>

	<?php echo $form->errorSummary($model, NULL, NULL, CiviGlobals::$infoboxClass); ?>

	<div class="row">
		<?php echo $form->label($model,'email_adds'); ?>
		<?php echo $form->textArea($model,'email_adds',array('rows'=>5, 'cols'=>2000, 'value'=>$model->email_adds)); ?>
		<?php echo $form->error($model,'email_adds'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'email_text'); ?>
		<?php echo $form->textArea($model,'email_text',array('rows'=>15,'cols'=>50)); ?>
		<?php echo $form->error($model,'email_text'); ?>
	</div>	

	<div class="row buttons">
		<?php echo CHtml::submitButton(Yii::t('app', 'email.send.button'), CiviGlobals::$buttonClass); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->