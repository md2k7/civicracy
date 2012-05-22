<?php

$this->breadcrumbs=array(
    'Vote'=>array('/vote'),
    $categoryModel->name . ' Vote',
);

?>
<h1><?php echo $categoryModel->name; ?> Vote</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model, 'categoryModel'=>$categoryModel, 'candidates'=>$candidates)); ?>
