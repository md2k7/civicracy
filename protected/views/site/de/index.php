<?php $this->pageTitle=Yii::app()->name; ?>

<h1>Willkommen bei <i><?php echo CHtml::encode(Yii::app()->name); ?></i></h1>

<p>Glückwunsch! Hier könnte Ihr Text stehen.</p>

<p>Diese Seite kann durch folgende Files verändert werden:</p>
<ul>
	<li>View file: <tt><?php echo __FILE__; ?></tt></li>
	<li>Layout file: <tt><?php echo $this->getLayoutFile('main'); ?></tt></li>
</ul>

<p>Noch mehr Werbung für Yii stand hier in der englischen Version.</p>
