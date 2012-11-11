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
				<h2><?php echo CHtml::encode($category->institution); ?></h2>
				<h3><?php echo CHtml::encode($category->name); ?></h3>
				<div class="hero-description">
					<p><?php echo CHtml::encode($category->description); ?></p>
				</div>
			</div>
			<div class="container"></div>
		</div>
		<div class="main-content">
			<div class="responsibility">
				<h4><?php echo Yii::t('app', 'vote.ownWeight'); ?></h4>
				<div class="responsibility-number"><?php echo CHtml::encode($weight); ?></div>
				<img src="<?php echo Yii::app()->request->baseUrl; ?>/img/responsibility.png" alt="<?php echo Yii::t('app', 'vote.ownWeight'); ?>" />
			</div>
			<h4><?php echo Yii::t('app', 'menu.categoryVote', array('{category}' => $category->name)); ?></h4>
			<?php echo Yii::t('app', 'vote.explainVoting'); ?>

<?php echo $this->renderPartial('_form', array('model'=>$model, 'category'=>$category, 'candidates'=>$candidates, 'id'=>$id)); ?>
		</div>