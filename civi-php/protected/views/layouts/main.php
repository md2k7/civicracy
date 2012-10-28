<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />

	<!-- blueprint CSS framework -->
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/screen.css" media="screen, projection" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css" media="print" />
	<!--[if lt IE 8]>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection" />
	<![endif]-->

	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css" />

	<link rel="icon" href="<?php echo Yii::app()->request->baseUrl; ?>/images/favicon.ico" type="image/x-icon" />

	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>

<div class="container" id="page">

	<div id="header">
		<div id="logo"><?php echo CHtml::encode(Yii::app()->name); ?></div>
	</div><!-- header -->

	<div id="mainmenu">
		<?php $this->widget('zii.widgets.CMenu',array(
			'items'=>array(
				array('label' => Yii::t('app', 'menu.vote'), 'url'=>array('/vote/index'), 'visible'=>(!Yii::app()->user->isGuest && !Yii::app()->user->isAdmin)),
				array('label' => Yii::t('app', 'menu.categories'), 'url'=>array('/category/admin'), 'visible'=>(!Yii::app()->user->isGuest && Yii::app()->user->isAdmin)),
				array('label' => Yii::t('app', 'menu.users'), 'url'=>array('/user/admin'), 'visible'=>(!Yii::app()->user->isGuest && Yii::app()->user->isAdmin)),
				array('label' => Yii::t('app', 'menu.login'), 'url'=>array('/site/login'), 'visible'=>Yii::app()->user->isGuest),
				array('label' => Yii::t('app', 'menu.settings'), 'url'=>array('/user/settings'), 'visible'=>!Yii::app()->user->isGuest),
				array('label' => Yii::t('app', 'menu.logout', array('{user}' => Yii::app()->user->name)), 'url'=>array('/site/logout'), 'visible'=>!Yii::app()->user->isGuest)
			),
		)); ?>
	</div><!-- mainmenu -->
	<?php if(isset($this->breadcrumbs)):?>
		<?php $this->widget('zii.widgets.CBreadcrumbs', array(
			'links'=>$this->breadcrumbs,
		)); ?><!-- breadcrumbs -->
	<?php endif?>

	<?php echo $content; ?>

	<div class="clear"></div>

	<div id="footer">
		<?php echo $this->renderPartial('//site/_version'); ?><br/>
		<?php /* echo Yii::t('app', 'footer.copyright', array('{date}' => date('Y'))); ?><br/><?php */ ?>
		<?php /* echo Yii::powered(); */ ?>
		<?php echo Yii::t('app', 'footer.silk'); ?><br/>
	</div><!-- footer -->

</div><!-- page -->

</body>
</html>
