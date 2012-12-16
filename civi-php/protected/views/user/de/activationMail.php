<?php

/*

NOTE: there is no need to escape things with CHtml::encode() here, as this is not a HTML mail.

*/

?>Hallo, <?php echo $model->realname; ?>!

Du hast nun die Möglichkeit, Dich auf der Civicracy-Plattform zu registrieren.

Bitte vergebe dazu hier ein neues Passwort: <?php echo $url; ?>

Danach kannst du deine Stimme abgeben.

Viel Spaß mit Civi!

-----------------------------------------------------------
Civi unter <?php echo Yii::app()->params['registration.url']; ?> am <?php echo date('d.m.Y H:i:s'); ?>
