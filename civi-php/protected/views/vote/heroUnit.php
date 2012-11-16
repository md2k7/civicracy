<?php

/**
 * "Hero unit": Big blue box on top of the page with Civicracy logo
 *
 * @param Category $category the current category we are viewing
 */

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
