<?php
$this->breadcrumbs=array(
	Yii::t('app', 'menu.settings') => array('settings'),
);
?>

<h1><?php echo Yii::t('app', 'menu.settings'); ?></h1>

<?php

echo $this->renderPartial('settingsForm', array('model'=>$model, 'message'=>$message));

?>
