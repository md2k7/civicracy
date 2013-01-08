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
<?php /* ?>
				<div class="register-box">
					<p><a class="btn btn-primary btn-large" href="<?php echo $this->createUrl('/site/login'); ?>">Civi erstellen</a></p><p>Eigenen Bereich zum Abstimmen anlegen.</p>
				</div>
<?php */ ?>
				<div class="register-box">
					<p><a class="btn btn-primary btn-large" href="<?php echo $this->createUrl('/user/create'); ?>">Benutzer erstellen</a></p><p>Neu hier?</p>
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
			<li><strong>Jeder ist wählbar.</strong><br/>Man wählt einfach eine bekannte Person, die man kennt und der man vertraut, die richtigen Entscheidungen zu treffen.</li>
			<li><strong>Mehrere Sieger.</strong><br/>Es gibt nicht nur einen Wahlsieger – die besten Köpfe bilden ein Gremium, das gemeinsam entscheidet.</li>
			<li><strong>Wahl ist immer.</strong><br/>Stell' dir vor, es ist immer Wahl! Entscheidungsträger können jederzeit zur Verantwortung gezogen werden. Entscheidungen werden immer von denen getroffen, die das meiste Vertrauen haben.</li>
			<li><strong>Vertrauen wird weitergegeben.</strong><br/>Jede Stimme zählt: Meine Verantwortung ist nicht verloren, selbst wenn ich nicht als Entscheidungsträger in ein Gremium berufen werde. Ich entscheide, wem ich meine gesamte Verantwortung weitergebe.</li>
			<li><strong>Expertise ist wichtig.</strong><br/>Wer mehr von der Sache versteht, der vertraut man auch mehr, die richtigen Entscheidungen zu treffen.</li>
			<li><strong>Keine Wahlpflicht.</strong><br/>Es muss nicht immer gewählt werden – es reicht, wenn das Vertrauen ein einziges Mal jemanden gegeben wird, die am politischen Geschehen interessiert ist, um die eigene Stimme dauerhaft einzubringen.</li>
			<li><strong>Expertenmeinungen zählen.</strong><br/>Selbst wenn sich Experten mit hohem Vertrauen nicht an der politischen Diskussion beteiligen wollen, können sie ihr gesammeltes Vertrauen an die richtigen Personen weitergeben.</li>
			</ul>

			<h2>Für wen?</h2>
			<p>Für alle! Civicracy richtet sich aber in erster Linie an Organisationen (wie Schulen oder Vereine), die eine höhere Beteiligung der Menschen an der Entscheidungsfindung erreichen wollen.</p>
<!--
			<h2>Wie?</h2>
			<p>Einfach ausprobieren und ein <a class="btn btn-primary" href="<?php echo $this->createUrl('/site/login'); /* TODO */ ?>">Civi erstellen</a>!</p>
-->
		</div>
