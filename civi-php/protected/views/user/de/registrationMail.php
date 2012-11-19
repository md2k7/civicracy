<?php

/*

NOTE: there is no need to escape things with CHtml::encode() here, as this is not a HTML mail.

*/

?>Hallo <?php echo $model->realname; ?>!

Du wurdest am <?php echo date('d.m.Y H:i:s'); ?> auf der Civi-Plattform unter <?php echo Yii::app()->params['registration.url']; ?> registriert.

Hier sind Deine Zugangsdaten:

Benutzername: <?php echo $model->username; ?>

Passwort: <?php echo $password; ?>

Dein Passwort kannst Du unter "Einstellungen" ändern.

Viel Spaß mit Civi!
