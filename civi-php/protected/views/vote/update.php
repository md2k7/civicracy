<?php

$this->breadcrumbs=array(
    Yii::t('app', 'menu.vote') => array('/vote'),
	Yii::t('app', 'menu.categoryVote', array('{category}' => $categoryModel->name)),
);

?>
		<div class="hero-unit">
			<div class="hero-left">
				<div class="hero-title">
					<h1>Civicracy</h1>
					<p>Demokratisch Entscheidungsträger finden</p>
				</div>
				<div class="hero-logo">
					<img src="<?php echo Yii::app()->request->baseUrl; ?>/img/civicracy.png" alt="Kreise" />
				</div>
			</div>
			<div class="hero-right hero-title-right">
				<h2>HTL Rennweg</h2>
				<h3>Schülerrat</h3>
				<div class="hero-description">
					<p>Der Schülerrat wird per Civicracy demokratisch gewählt und ist ein Organ zur Unterstützung des Schulsprechers.</p>
				</div>
			</div>
			<div class="container"></div>
		</div>
		<div class="main-content">
			<h4><?php echo Yii::t('app', 'menu.categoryVote', array('{category}' => $categoryModel->name)); ?></h4>

<?php echo $this->renderPartial('_form', array('model'=>$model, 'categoryModel'=>$categoryModel, 'candidates'=>$candidates)); ?>
		</div>