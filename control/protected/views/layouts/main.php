<!DOCTYPE html>
<html lang="en">
<head>
    <title><?php echo CHtml::encode($this->pageTitle); ?></title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="<?= Yii::app()->request->baseurl; ?>/images/icons/favicon.ico">
    <link rel="apple-touch-icon" href="<?= Yii::app()->request->baseurl; ?>/images/icons/favicon.png">
    <link rel="apple-touch-icon" sizes="72x72" href="<?= Yii::app()->request->baseurl; ?>/images/icons/favicon-72x72.png">
    <link rel="apple-touch-icon" sizes="114x114" href="<?= Yii::app()->request->baseurl; ?>/images/icons/favicon-114x114.png">
    <!--Loading bootstrap css-->
    <!-- <link type="text/css" rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,400,300,700">
    <link type="text/css" rel="stylesheet" href="http://fonts.googleapis.com/css?family=Oswald:400,700,300"> -->
    <link type="text/css" rel="stylesheet" href="<?= Yii::app()->request->baseurl; ?>/assets/kadmin/styles/jquery-ui-1.10.4.custom.min.css">
    <link type="text/css" rel="stylesheet" href="<?= Yii::app()->request->baseurl; ?>/assets/kadmin/styles/font-awesome.min.css">
    <link type="text/css" rel="stylesheet" href="<?= Yii::app()->request->baseurl; ?>/css/font-awesome/css/font-awesome.min.css">
    <link type="text/css" rel="stylesheet" href="<?= Yii::app()->request->baseurl; ?>/assets/kadmin/styles/bootstrap.min.css">
    <link type="text/css" rel="stylesheet" href="<?= Yii::app()->request->baseurl; ?>/assets/kadmin/styles/animate.css">
    <link type="text/css" rel="stylesheet" href="<?= Yii::app()->request->baseurl; ?>/assets/kadmin/styles/all.css">
    <link type="text/css" rel="stylesheet" href="<?= Yii::app()->request->baseurl; ?>/assets/kadmin/styles/main.css">
    <link type="text/css" rel="stylesheet" href="<?= Yii::app()->request->baseurl; ?>/assets/kadmin/styles/style-responsive.css">
    <link type="text/css" rel="stylesheet" href="<?= Yii::app()->request->baseurl; ?>/assets/kadmin/styles/zabuto_calendar.min.css">
    <link type="text/css" rel="stylesheet" href="<?= Yii::app()->request->baseurl; ?>/assets/kadmin/styles/pace.css">
    <link type="text/css" rel="stylesheet" href="<?= Yii::app()->request->baseurl; ?>/assets/kadmin/styles/jquery.news-ticker.css">
    <link type="text/css" rel="stylesheet" href="<?= Yii::app()->request->baseurl; ?>/css/custom.css">
    <link type="text/css" rel="stylesheet" href="<?= Yii::app()->request->baseurl; ?>/assets/plugins/bootstrap-modal/css/bootstrap-modal.css">

    <!-- DATE TIME PICKERS-->
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/assets/plugins/bootstrap-datepicker/css/datepicker3.css"/>
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/assets/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css"/>

    <script src="<?php echo Yii::app()->request->baseurl; ?>/assets/kadmin/script/jquery-1.10.2.min.js"></script>
    <script src="<?php echo Yii::app()->request->baseurl; ?>/assets/kadmin/script/jquery-migrate-1.2.1.min.js"></script>
    <script src="<?php echo Yii::app()->request->baseurl; ?>/assets/kadmin/script/jquery-ui.js"></script>
    <script src="<?php echo Yii::app()->request->baseurl; ?>/assets/kadmin/script/jquery.ba-bbq.min.js"></script>
</head>
<body>
<div class="modal fade" tabindex="-1" role="dialog" id="modal_alert">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">x</span></button>
                <h4 class="modal-title" id="modal_title">Aviso</h4>
            </div>
            <div class="modal-body">
                Cargando...
            </div>
            <div class="modal-footer" id="modal_botones">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
    <div class="wrapper-parent">
        <!--BEGIN BACK TO TOP-->
        <a id="totop" href="#"><i class="fa fa-angle-up"></i></a>
        <!--END BACK TO TOP-->
        <!--BEGIN TOPBAR-->
        <div id="header-topbar-option-demo" class="page-header-topbar">
            <nav id="topbar" role="navigation" style="margin-bottom: 0;" data-step="3" class="navbar navbar-default navbar-static-top">
                <div class="navbar-header">
                    <button type="button" data-toggle="collapse" data-target=".sidebar-collapse" class="navbar-toggle">
                        <span class="sr-only">Toggle navigation</span><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span>
                    </button>
                    <a id="logo" href="<?= Yii::app()->request->baseUrl; ?>/site/index" class="logo navbar-brand">
                        <span class="fa fa-rocket"></span><span class="logo-text"><img height="40px" src="<?= Yii::app()->request->baseUrl; ?>/images/icons/logo.png"></span><span style="display: none" class="logo-text-icon">µ</span>
                    </a>
                </div>
                <div class="topbar-main">
                    <a id="menu-toggle" href="#" class="hidden-xs"><i class="fa fa-bars"></i></a>
                    <ul class="nav navbar navbar-top-links navbar-right mbn">
                        <li class="dropdown topbar-user"><a data-hover="dropdown" href="#" class="dropdown-toggle"><img src="<?= Yii::app()->request->baseurl; ?>/images/avatar/48.jpg" alt="" class="img-responsive img-circle"/>&nbsp;<span class="hidden-xs"><?= Yii::app()->user->getState('usuario_nombre'); ?></span>&nbsp;<span class="caret"></span></a>
                            <ul class="dropdown-menu dropdown-user pull-right">
                                <li><a href="#"><i class="fa fa-user"></i>Perfil</a></li>
                                <li class="divider"></li>
                                <li><a href="<?= Yii::app()->request->baseUrl; ?>/site/logout"><i class="fa fa-key"></i>Salir</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
        <!--END TOPBAR-->
        <div id="wrapper">
            <!--BEGIN SIDEBAR MENU-->
            <?php 
                if(Yii::app()->user->getState('perfil')=='Administrador'){
                        include_once("menu-admin.php");
                }
            ?>
            <!--END SIDEBAR MENU-->
            <!--BEGIN PAGE WRAPPER-->
            <div id="page-wrapper">
                
                <!--BEGIN CONTENT-->
                <div class="page-content">
                    <?php echo $content; ?>
                </div>
                <!--END CONTENT-->
                <!--BEGIN FOOTER-->
                <div id="footer">
                    <div class="copyright">
                        <a href="http://bom.com.mx">2015 © Botas y Botines BOM</a></div>
                </div>
                <!--END FOOTER-->
            </div>
            <!--END PAGE WRAPPER-->
        </div>
    </div>
    <script src="<?php echo Yii::app()->request->baseurl; ?>/assets/kadmin/script/bootstrap.min.js"></script>
    <script src="<?php echo Yii::app()->request->baseurl; ?>/assets/kadmin/script/bootstrap-hover-dropdown.js"></script>

    <script src="<?php echo Yii::app()->request->baseurl; ?>/assets/kadmin/script/jquery.menu.js"></script>
    <script src="<?php echo Yii::app()->request->baseurl; ?>/assets/kadmin/script/pace.min.js"></script>
    <script src="<?php echo Yii::app()->request->baseurl; ?>/assets/kadmin/script/holder.js"></script>
    <script src="<?php echo Yii::app()->request->baseurl; ?>/assets/kadmin/script/responsive-tabs.js"></script>

    <script src="<?php echo Yii::app()->request->baseurl; ?>/assets/kadmin/script/zabuto_calendar.min.js"></script>
    <script src="<?php echo Yii::app()->request->baseurl; ?>/assets/kadmin/script/index.js"></script>
    <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/assets/plugins/jquery.blockUI.js"></script>
    <!--LOADING SCRIPTS FOR CHARTS-->
    <!--
    <script src="<?php echo Yii::app()->request->baseurl; ?>/assets/kadmin/script/highcharts.js"></script>
    <script src="<?php echo Yii::app()->request->baseurl; ?>/assets/kadmin/script/data.js"></script>
    <script src="<?php echo Yii::app()->request->baseurl; ?>/assets/kadmin/script/drilldown.js"></script>
    <script src="<?php echo Yii::app()->request->baseurl; ?>/assets/kadmin/script/exporting.js"></script>
    <script src="<?php echo Yii::app()->request->baseurl; ?>/assets/kadmin/script/highcharts-more.js"></script>
    <script src="<?php echo Yii::app()->request->baseurl; ?>/assets/kadmin/script/charts-highchart-pie.js"></script>
    <script src="<?php echo Yii::app()->request->baseurl; ?>/assets/kadmin/script/charts-highchart-more.js"></script>
    -->
    <!--CORE JAVASCRIPT-->
    <script src="<?php echo Yii::app()->request->baseurl; ?>/assets/kadmin/script/main.js"></script>

    <!-- DateTime Pickers -->
    <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
    <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/assets/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js"></script>
    <!-- <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/modal.js"></script> -->
    <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/assets/plugins/bootstrap-modal/js/bootstrap-modal.js"></script>
    <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/assets/plugins/bootstrap-modal/js/bootstrap-modalmanager.js"></script>
    <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/custom.js"></script>
    <script>
        $('.datepicker').datepicker();
    </script>
</body>
</html>
