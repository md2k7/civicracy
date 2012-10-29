<?php

$this->breadcrumbs=array(
    Yii::t('app', 'menu.vote') => array('/vote'),
	Yii::t('app', 'menu.categoryVote', array('{category}' => $category->name)),
);

?>
		<div class="hero-unit">
			<div class="hero-left">
				<div class="hero-title">
					<h1><?php echo CHtml::encode(Yii::app()->name); ?></h1>
					<p><?php echo Yii::t('app', 'site.motto'); ?></p>
				</div>
				<div class="hero-logo">
					<img src="<?php echo Yii::app()->request->baseUrl; ?>/img/civicracy.png" alt="Kreise" />
				</div>
			</div>
			<div class="hero-right hero-title-right">
				<h2>HTL Rennweg</h2>
				<h3><?php echo $category->name; ?></h3>
				<div class="hero-description">
					<p><?php echo $category->description; ?></p>
				</div>
			</div>
			<div class="container"></div>
		</div>
		<div class="main-content">
			<h4><?php echo Yii::t('app', 'menu.categoryVote', array('{category}' => $category->name)); ?></h4>

<?php echo $this->renderPartial('_form', array('model'=>$model, 'category'=>$category, 'candidates'=>$candidates)); ?>
		</div>