<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'vote-form',
	'enableAjaxValidation'=>false,
)); ?>

	<?php echo Yii::t('app', 'forms.required'); ?>

	<?php echo $form->errorSummary($model); ?>

<?php /* ?>
	<div class="row">
		<?php echo $form->labelEx($category,'name'); ?>
		<p><?php echo $category->name; ?></p>
	</div>
<?php */ ?>

	<div class="row">
		<?php echo $form->labelEx($model,'candidate_id'); ?>
<?php

$this->widget('ext.combobox.EJuiComboBox', array(
	'name' => 'candidate',
	'data' => $candidates['names'],
	'options' => array(
		'allowText' => false,
		'maxSuggestCount' => 5,
	),
	// Options passed to the text input
	'htmlOptions' => array('size' => 45),
));

?>
		<script>
<?php

foreach($candidates['names'] as $can) {
	$slogan = $candidates['slogans'][$can];
	if($slogan != "") {
?>
			$('#candidate_select > option[value="<?php echo CHtml::encode($can); ?>"]').data('desc', '<?php echo CHtml::encode($slogan); ?>');
<?php
	}
}

?>
		</script>
		<?php echo $form->error($model,'candidate_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'reason'); ?>
		<?php echo $form->textField($model,'reason',array('size'=>60,'class'=>'span12')); ?>
		<?php echo $form->error($model,'reason'); ?>
	</div>
	<?php echo $form->hiddenField($model,'category_id'); ?>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('app', 'vote.button') : Yii::t('app', 'vote.update.button'), CiviGlobals::$buttonClass); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
