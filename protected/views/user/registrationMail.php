<?php

/*

NOTE: there is no need to escape things with CHtml::encode() here, as this is not a HTML mail.

*/

?>Hello <?php echo $model->realname; ?>!

On the <?php echo date('m/d/Y H:i:s'); ?>, you have registered on the Civi plattform at <?php echo Yii::app()->params['registration.url']; ?>

Here are your credentials:

Username: <?php echo $model->username; ?>

Password: <?php echo $password; ?>

Have fun with Civi!
