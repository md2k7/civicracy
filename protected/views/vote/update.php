<?php

$this->breadcrumbs=array(
    Yii::t('app', 'Vote') => array('/vote'),
	Yii::t('app', '{category} Vote', array('{category}' => $categoryModel->name)),
);

?>
<h1><?php echo Yii::t('app', '{category} Vote', array('{category}' => $categoryModel->name)); ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model, 'categoryModel'=>$categoryModel, 'candidates'=>$candidates)); ?>
