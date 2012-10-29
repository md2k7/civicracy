<?php

$this->breadcrumbs=array(
    Yii::t('app', 'menu.vote') => array('/vote'),
    Yii::t('app', 'menu.viewCategoryVote', array('{category}' => $category->name)),
);

$this->menu=array(
	array('label' => Yii::t('app', 'menu.vote.again'), 'url'=>array('update', 'id' => $id)),
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
			<div class="responsibility">
				<h4><?php echo Yii::t('app', 'vote.ownWeight'); ?></h4>
				<div class="responsibility-number"><?php echo $weight; ?></div>
				<img src="<?php echo Yii::app()->request->baseUrl; ?>/img/responsibility.png" alt="<?php echo Yii::t('app', 'vote.ownWeight'); ?>" />
			</div>
			<h4><?php echo Yii::t('app', 'vote.path'); ?></h4>
			<div class="container">
<?php foreach($votePath as $vote) { ?>
				<div class="vp-row">
					<div class="vp-left">
						<img src="<?php echo Yii::app()->request->baseUrl; ?>/img/user_arrows.png" alt="User" />
					</div>
					<div class="vp-right">
						<h5><?php echo $vote->realname; ?></h5>
						<p><?php echo $vote->slogan == '' ? Yii::t('app', 'vote.noslogan') : $vote->slogan; ?></p>
					</div>
				</div>
<?php if($vote !== end($votePath)) { ?>
				<div class="vp-row vp-row-arrow">
					<div class="vp-left">
						<img src="<?php echo Yii::app()->request->baseUrl; ?>/img/arrow.png" alt="delegiert" />
					</div>
					<div class="vp-right"><?php echo $vote->reason; ?></div>
				</div>
<?php } } ?>
				<p>&nbsp;</p>
			</div>
			<p><a class="btn btn-primary btn-civi" href="<?php echo $this->createUrl('update', array('id' => $id)); ?>"><?php echo Yii::t('app', $voted ? 'vote.update.button' : 'vote.button'); ?></a></p>
		</div>