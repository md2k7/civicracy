<?php
$this->pageTitle=Yii::app()->name . ' - ' . Yii::t('app', 'menu.login');
$this->breadcrumbs=array(
	Yii::t('app', 'menu.login'),
);
?>

<h1><?php echo Yii::t('app', 'menu.login'); ?></h1>

<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'login-form',
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
)); ?>

	<?php echo Yii::t('app', 'forms.required'); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'username'); ?>
		<?php echo $form->textField($model,'username'); ?>
		<?php echo $form->error($model,'username'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'password'); ?>
		<?php echo $form->passwordField($model,'password'); ?>
		<?php echo $form->error($model,'password'); ?>
	</div>

	<div class="row rememberMe">
		<?php echo $form->checkBox($model,'rememberMe'); ?>
		<?php echo $form->label($model,'rememberMe', array('class' => 'inline')); ?>
		<?php echo $form->error($model,'rememberMe'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton(Yii::t('app', 'login.button'), CiviGlobals::$buttonClass); ?>
	</div>

<?php $this->endWidget(); ?>
</div><!-- form -->
