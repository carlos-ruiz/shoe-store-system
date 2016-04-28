<?php /* @var $this Controller */ ?>
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta name="language" content="en">

	<!-- blueprint CSS framework -->
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/screen.css" media="screen, projection">
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css" media="print">
	<!--[if lt IE 8]>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection">
	<![endif]-->

	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css">
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css">

	<!--Loading bootstrap css-->
    <link type="text/css" rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,400,300,700">
    <link type="text/css" rel="stylesheet" href="http://fonts.googleapis.com/css?family=Oswald:400,700,300">
    <link type="text/css" rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/assets/kadmin/styles/jquery-ui-1.10.4.custom.min.css">
    <link type="text/css" rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/assets/kadmin/styles/font-awesome.min.css">
    <link type="text/css" rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/assets/kadmin/styles/bootstrap.min.css">
    <link type="text/css" rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/assets/kadmin/styles/animate.css">
    <link type="text/css" rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/assets/kadmin/styles/all.css">
    <link type="text/css" rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/assets/kadmin/styles/main.css">
    <link type="text/css" rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/assets/kadmin/styles/style-responsive.css">
    <link type="text/css" rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/assets/kadmin/styles/zabuto_calendar.min.css">
    <link type="text/css" rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/assets/kadmin/styles/pace.css">
    <link type="text/css" rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/assets/kadmin/styles/jquery.news-ticker.css">

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
				array('label'=>'Home', 'url'=>array('/site/index')),
				array('label'=>'About', 'url'=>array('/site/page', 'view'=>'about')),
				array('label'=>'Contact', 'url'=>array('/site/contact')),
				array('label'=>'Login', 'url'=>array('/site/login'), 'visible'=>Yii::app()->user->isGuest),
				array('label'=>'Logout ('.Yii::app()->user->name.')', 'url'=>array('/site/logout'), 'visible'=>!Yii::app()->user->isGuest)
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
		Copyright &copy; <?php echo date('Y'); ?> by My Company.<br/>
		All Rights Reserved.<br/>
		<?php echo Yii::powered(); ?>
	</div><!-- footer -->

</div><!-- page -->
	<script src="<?php echo Yii::app()->request->baseUrl; ?>/assets/kadmin/script/jquery-1.10.2.min.js"></script>
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/assets/kadmin/script/jquery-migrate-1.2.1.min.js"></script>
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/assets/kadmin/script/jquery-ui.js"></script>
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/assets/kadmin/script/bootstrap.min.js"></script>
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/assets/kadmin/script/bootstrap-hover-dropdown.js"></script>
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/assets/kadmin/script/html5shiv.js"></script>
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/assets/kadmin/script/respond.min.js"></script>
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/assets/kadmin/script/jquery.metisMenu.js"></script>
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/assets/kadmin/script/jquery.slimscroll.js"></script>
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/assets/kadmin/script/jquery.cookie.js"></script>
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/assets/kadmin/script/icheck.min.js"></script>
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/assets/kadmin/script/custom.min.js"></script>
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/assets/kadmin/script/jquery.news-ticker.js"></script>
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/assets/kadmin/script/jquery.menu.js"></script>
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/assets/kadmin/script/pace.min.js"></script>
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/assets/kadmin/script/holder.js"></script>
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/assets/kadmin/script/responsive-tabs.js"></script>
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/assets/kadmin/script/jquery.flot.js"></script>
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/assets/kadmin/script/jquery.flot.categories.js"></script>
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/assets/kadmin/script/jquery.flot.pie.js"></script>
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/assets/kadmin/script/jquery.flot.tooltip.js"></script>
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/assets/kadmin/script/jquery.flot.resize.js"></script>
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/assets/kadmin/script/jquery.flot.fillbetween.js"></script>
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/assets/kadmin/script/jquery.flot.stack.js"></script>
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/assets/kadmin/script/jquery.flot.spline.js"></script>
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/assets/kadmin/script/zabuto_calendar.min.js"></script>
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/assets/kadmin/script/index.js"></script>
    <!--LOADING SCRIPTS FOR CHARTS-->
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/assets/kadmin/script/highcharts.js"></script>
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/assets/kadmin/script/data.js"></script>
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/assets/kadmin/script/drilldown.js"></script>
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/assets/kadmin/script/exporting.js"></script>
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/assets/kadmin/script/highcharts-more.js"></script>
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/assets/kadmin/script/charts-highchart-pie.js"></script>
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/assets/kadmin/script/charts-highchart-more.js"></script>
    <!--CORE JAVASCRIPT-->
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/assets/kadmin/script/main.js"></script>
    <script>        (function (i, s, o, g, r, a, m) {
            i['GoogleAnalyticsObject'] = r;
            i[r] = i[r] || function () {
                (i[r].q = i[r].q || []).push(arguments)
            }, i[r].l = 1 * new Date();
            a = s.createElement(o),
            m = s.getElementsByTagName(o)[0];
            a.async = 1;
            a.src = g;
            m.parentNode.insertBefore(a, m)
        })(window, document, 'script', '//www.google-analytics.com/analytics.js', 'ga');
        ga('create', 'UA-145464-12', 'auto');
        ga('send', 'pageview');


</script>

</body>
</html>
