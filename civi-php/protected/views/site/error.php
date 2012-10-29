<?php
$this->pageTitle=Yii::app()->name . ' - ' . Yii::t('app', 'error');
$this->breadcrumbs=array(
	Yii::t('app', 'error'),
);
?>
		<div class="main-content">
<h2><?php echo Yii::t('app', 'error') . ' ' . $code; ?></h2>

<div class="error">
<?php echo CHtml::encode($message); ?>
</div>
		</div>