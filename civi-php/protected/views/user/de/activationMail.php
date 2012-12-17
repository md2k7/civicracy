<?php

/*

NOTE: there is no need to escape things with CHtml::encode() here, as this is not a HTML mail.

*/

?>Hallo, <?php echo $model->realname; ?>!

Du hast nun die Möglichkeit, Dich auf der Civicracy-Plattform zu registrieren.

Um es Dir noch einmal in Erinnerung zu rufen: Dies ist ein Pilotprojekt, im Nachhinein werden Deine Daten anonym zu wissenschaftlichen Zwecken ausgewertet.

Bitte vergib hier ein neues Passwort, um Dich zu registrieren: <?php echo $url; ?>


Danach kannst Du Deine Stimme abgeben.

Viel Spaß mit Civi!

-----------------------------------------------------
Civi unter <?php echo Yii::app()->params['registration.url']; ?> am <?php echo date('d.m.Y H:i:s'); ?>
