<?php

$this->breadcrumbs=array(
    Yii::t('app', 'menu.vote') => array('/vote'),
	Yii::t('app', 'menu.categoryVote', array('{category}' => $categoryModel->name)),
);

?>
<h1><?php echo Yii::t('app', 'menu.categoryVote', array('{category}' => $categoryModel->name)); ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model, 'categoryModel'=>$categoryModel, 'candidates'=>$candidates)); ?>
