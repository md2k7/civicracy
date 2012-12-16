		<div class="main-content">
<?php
$this->breadcrumbs=array(
	Yii::t('app', 'menu.settings') => array('settings'),
);
?>

			<h1>Benutzer aktivieren</h1>
<?php

if($valid) {
	echo $this->renderPartial('settingsForm', array('model'=>$user, 'message'=>'', 'activate'=>true));
} else {

?>
			<p>Falscher Aktivierungscode! Bitte den Link vollständig kopieren. Falls mit diesem Code noch kein Benutzer angelegt wurde und noch immer Probleme auftreten, Mail an: <a href="mailto:support@civicracy.at">support@civicracy.at</a>.</p>
<?php

}

?>
		</div>
