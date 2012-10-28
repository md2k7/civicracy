<?php $this->pageTitle=Yii::app()->name . ' - ' . Yii::t('app', 'site.motto'); ?>

		<div class="hero-unit">
			<div class="hero-left">
				<div class="hero-title">
					<h1><?php echo CHtml::encode(Yii::app()->name); ?></h1>
					<p><?php echo Yii::t('app', 'site.motto'); ?></p>
				</div>
				<div class="hero-logo">
					<img src="<?php echo Yii::app()->request->baseUrl; ?>/img/civicracy.png" alt="Civicracy Logo" />
				</div>
			</div>
			<div class="hero-right">
				<div class="register-box">
					<p><a class="btn btn-primary btn-large" href="<?php echo $this->createUrl('/site/login'); /* TODO */ ?>">Civi erstellen</a></p><p>Eigenen Bereich zum Abstimmen anlegen.</p>
				</div>
				<div class="register-box">
					<p><a class="btn btn-primary btn-large" href="<?php echo $this->createUrl('/site/login'); ?>">Login</a></p><p>Ergebnisse betrachten und abstimmen.</p>
				</div>
			</div>
			<div class="container"></div>
		</div>
		<div class="main-content">
			<h2>Was ist ein Civi?</h2>
			<p>Ein Civi ist eine <strong>elektronische Wahl</strong> nach dem <em>Civicracy</em>-Prinzip auf dieser Website.</p>
			<h2>Civicracy in Kürze</h2>
			<ul>
			<li><strong>Jeder ist wählbar.</strong><br/>Man wählt einfach jemanden, den man kennt und dem man vertraut, die richtigen Entscheidungen zu treffen.</li>
			<li><strong>Mehrere Sieger.</strong><br/>Es gibt nicht nur einen Wahlsieger – die besten Köpfe bilden ein Gremium, das gemeinsam entscheidet.</li>
			<li><strong>Wahl ist immer.</strong><br/>Stell' dir vor, es ist immer Wahl! Entscheidungsträger können jederzeit zur Verantwortung gezogen werden. Entscheidungen werden immer von denen getroffen, die das meiste Vertrauen haben.</li>
			<li><strong>Vertrauen wird weitergegeben.</strong><br/>Jede Stimme zählt: Meine Verantwortung ist nicht verloren, selbst wenn ich nicht als Entscheidungsträger in ein Gremium berufen werde. Ich entscheide, wem ich meine gesamte Verantwortung weitergebe.</li>
			<li><strong>Politik kann jeder.</strong><br/>Wer mehr von der Sache versteht, dem vertraut man auch mehr, die richtigen Entscheidungen zu treffen.</li>
			<li><strong>Keine Wahlpflicht.</strong><br/>Man muss nicht immer wählen – es reicht, wenn man ein einziges Mal sein Vertrauen jemandem gibt, der am politischen Geschehen interessiert ist, um seine Stimme dauerhaft einzubringen.</li>
			<li><strong>Expertenmeinungen zählen.</strong><br/>Selbst wenn sich Experten mit hohem Vertrauen nicht an der politischen Diskussion beteiligen wollen, können sie ihr gesammeltes Vertrauen an die richtigen Personen weitergeben.</li>
			</ul>

			<h2>Für wen?</h2>
			<p>Für alle! Civicracy richtet sich aber in erster Linie an Organisationen (wie Schulen oder Vereine), die eine höhere Beteiligung der Menschen an der Entscheidungsfindung erreichen wollen.</p>

			<h2>Wie?</h2>
			<p>Einfach ausprobieren und ein <a class="btn btn-primary" href="<?php echo $this->createUrl('/site/login'); /* TODO */ ?>">Civi erstellen</a>!</p>
		</div>
<!--
<h2>Bekannte Bugs</h2>

<ul>
	<li>Kategorie löschen -&gt; falsche Anfrage HTTP 400 (GET instead of POST)</li>
	<li>Kategorie löschen -&gt; constraint exception</li>
	<li>vermutlich auch: Benutzer löschen -&gt; constraint exception</li>
	<li>user1 -&gt; user3 -&gt; user1 loop: user1 weight falsch (hopefully fixed?)</li>
</ul>

<h2>Unvollständige TODO-List</h2>

<ul>
	<li>CSV-Import von Benutzern über die Admin-Oberfläche</li>
	<li>change credits</li>
	<li>Historisierung der Wahlen (d.h. meine Stimme im Zeitverlauf), zumindest auf der Datenbank</li>

	<li>"Admin-User erstellen" für Setup</li>
	<li>Anzeigen der Stimmen aller Leute, oder zumindest Top-Ranking (wer wird zum Rat?)</li>

	<li>Nice:</li>
	<li>Kategorie umbenennen in Wahl (election) - auf DB, GUI, im Code...</li>
	<li>Login-Controller Forward auf Profil, wenn schon eingeloggt</li>
	<li>Nach Login Landing auf Profil, nicht auf index</li>
	<li>Admin sollte nicht gelöscht werden können ;-)</li>
	<li>Stimme ändern: Benutzer, für den vorher abgestimmt wurde, anzeigen (default value)</li>
	<li>Fix double inclusion of jQuery in http://localhost/david/civi/index.php?r=category/admin</li>
</ul>
-->
