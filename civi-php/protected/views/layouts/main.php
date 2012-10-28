<!DOCTYPE html>
<html>
<head>
	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link href="<?php echo Yii::app()->request->baseUrl; ?>/css/bootstrap.min.css" rel="stylesheet" />
	<link href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css" rel="stylesheet" />
	<link href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css" rel="stylesheet" />

	<link rel="icon" href="<?php echo Yii::app()->request->baseUrl; ?>/img/favicon.ico" type="image/x-icon" />

	<?php Yii::app()->clientScript->registerCoreScript('jquery'); /* register jQuery every time, for top navbar */ ?>
</head>
<body>
	<div class="navbar navbar-inverse navbar-static-top">
		<div class="navbar-inner">
			<div class="container">
				<a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</a>
				<a class="brand" href="<?php echo $this->createUrl(Yii::app()->user->isGuest ? '/site/index' : '/vote/index'); ?>"><?php echo CHtml::encode(Yii::app()->name); ?></a>
				<div class="nav-collapse collapse">
<?php $this->widget('zii.widgets.CMenu',array(
	'encodeLabel'=>false,
	'items'=>array(
		array('label' => CHtml::encode(Yii::t('app', 'menu.vote')), 'url'=>array('/vote/index'), 'visible'=>(!Yii::app()->user->isGuest && !Yii::app()->user->isAdmin)),
		array('label' => CHtml::encode(Yii::t('app', 'menu.categories')) . ' <b class="caret"></b>', 'url'=>'#', 'visible'=>(!Yii::app()->user->isGuest && Yii::app()->user->isAdmin), 'itemOptions'=>array('class'=>'dropdown'), 'linkOptions'=>array('class'=>'dropdown-toggle','data-toggle'=>'dropdown'), 'submenuOptions'=>array('class'=>'dropdown-menu'), 'items'=>array(
			array('label' => CHtml::encode(Yii::t('app', 'menu.categories.manageAll')), 'active'=>false, 'url'=>array('/category/admin')),
			array('label' => CHtml::encode(Yii::t('app', 'menu.categories.create')), 'active'=>false, 'url'=>array('/category/create')),
		)),
		array('label' => CHtml::encode(Yii::t('app', 'menu.users')) . ' <b class="caret"></b>', 'url'=>'#', 'visible'=>(!Yii::app()->user->isGuest && Yii::app()->user->isAdmin), 'itemOptions'=>array('class'=>'dropdown'), 'linkOptions'=>array('class'=>'dropdown-toggle','data-toggle'=>'dropdown'), 'submenuOptions'=>array('class'=>'dropdown-menu'), 'items'=>array(
			array('label' => CHtml::encode(Yii::t('app', 'menu.users.manageAll')), 'active'=>false, 'url'=>array('/user/admin')),
			array('label' => CHtml::encode(Yii::t('app', 'menu.users.create')), 'active'=>false, 'url'=>array('/user/create')),
		)),
		array('label' => CHtml::encode(Yii::t('app', 'menu.login')), 'url'=>array('/site/login'), 'visible'=>Yii::app()->user->isGuest),
		array('label' => CHtml::encode(Yii::t('app', 'menu.settings')), 'url'=>array('/user/settings'), 'visible'=>!Yii::app()->user->isGuest),
		array('label' => CHtml::encode(Yii::t('app', 'menu.logout', array('{user}' => Yii::app()->user->name))), 'url'=>array('/site/logout'), 'visible'=>!Yii::app()->user->isGuest)
	),
	'htmlOptions'=>array('class' => 'nav'),
)); ?>
				</div><!--/.nav-collapse -->
			</div>
		</div>
	</div>
	<div class="container">
		<?php echo $content; ?>
		<footer>
			<hr/>
			<p>&copy; 2011-2012 Arbeitskreis "Demokratieforschung" der TU Wien.</p>
			<p><?php echo $this->renderPartial('//site/_version'); ?></p>
		</footer>
	</div>

	<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/bootstrap.min.js"></script>
</body>
</html>