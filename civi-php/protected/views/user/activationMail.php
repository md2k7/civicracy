<?php

/*

NOTE: there is no need to escape things with CHtml::encode() here, as this is not a HTML mail.

*/

?>Hello <?php echo $model->realname; ?>!

On the <?php echo date('m/d/Y H:i:s'); ?>, you have been given the possibility to register on the Civi plattform at <?php echo Yii::app()->params['registration.url']; ?>

Create a new password here: <?php echo $url; ?>

Have fun with Civi!
