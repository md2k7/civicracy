<?php

$this->breadcrumbs=array(
    Yii::t('app', 'menu.vote') => array('/vote'),
	Yii::t('app', 'menu.categoryVote', array('{category}' => $category->name)),
);

?>
		<?php echo $this->renderPartial('heroUnit', array('category' => $category)); ?>
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