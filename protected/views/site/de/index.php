<?php $this->pageTitle=Yii::app()->name; ?>

<h1>Willkommen bei <i><?php echo CHtml::encode(Yii::app()->name); ?></i></h1>
<p><?php echo $this->renderPartial('_version'); ?></p>

<h2>Benutzer</h2>
<ul>
	<li>Admin: admin/admin</li>
	<li>weitere User (im Moment 1-4): user1/user1, user2/user2, usw.</li>
</ul>

<h2>Bekannte Bugs</h2>

<ul>
	<li>Kategorie löschen -&gt; constraint exception</li>
	<li>vermutlich auch: Benutzer löschen -&gt; constraint exception</li>
	<li>Zählen der Stimmen im Baum falsch: Fehlende Rekursion</li>
</ul>

<h2>Unvollständige TODO-List</h2>

<ul>
	<li>Passwort ändern</li>
	<li>Admin: Passwort für Benutzer per E-Mail zurücksetzen</li>
	<li>"Admin-User erstellen" für Setup</li>
	<li>Silk Favicons nutzen und in Credits auf <a href="http://www.famfamfam.com/lab/icons/silk/">http://www.famfamfam.com/lab/icons/silk/</a> verlinken</li>
	<li>Kategorie-Beschreibung</li>
	<li>CSV import von Benutzern über die Admin-Oberfläche</li>
	<li>Anzeigen der Stimmen aller Leute, oder zumindest Top-Ranking (wer wird zum Rat?)</li>
	<li>Zyklenbehandlung wie im <a href="http://www.demokratieforschung.at/forum/board18-demokratiesimulation/board22-diskussionen/10-civicracy-webplattform-erster-ansatz/#post63">Forum</a></li>
	<li>change credits (im Moment fehlt dazu ein Konzept)</li>
	<li>Historisierung der Wahlen (d.h. meine Stimme im Zeitverlauf), zumindest auf der Datenbank</li>
</ul>
