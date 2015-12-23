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
    <link type="text/css" rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,400,300,700">
    <link type="text/css" rel="stylesheet" href="http://fonts.googleapis.com/css?family=Oswald:400,700,300">
    <link type="text/css" rel="stylesheet" href="<?= Yii::app()->request->baseurl; ?>/assets/kadmin/styles/jquery-ui-1.10.4.custom.min.css">
    <link type="text/css" rel="stylesheet" href="<?= Yii::app()->request->baseurl; ?>/assets/kadmin/styles/font-awesome.min.css">
    <link type="text/css" rel="stylesheet" href="<?= Yii::app()->request->baseurl; ?>/assets/kadmin/styles/bootstrap.min.css">
    <link type="text/css" rel="stylesheet" href="<?= Yii::app()->request->baseurl; ?>/assets/kadmin/styles/animate.css">
    <link type="text/css" rel="stylesheet" href="<?= Yii::app()->request->baseurl; ?>/assets/kadmin/styles/all.css">
    <link type="text/css" rel="stylesheet" href="<?= Yii::app()->request->baseurl; ?>/assets/kadmin/styles/main.css">
    <link type="text/css" rel="stylesheet" href="<?= Yii::app()->request->baseurl; ?>/assets/kadmin/styles/style-responsive.css">
    <link type="text/css" rel="stylesheet" href="<?= Yii::app()->request->baseurl; ?>/assets/kadmin/styles/zabuto_calendar.min.css">
    <link type="text/css" rel="stylesheet" href="<?= Yii::app()->request->baseurl; ?>/assets/kadmin/styles/pace.css">
    <link type="text/css" rel="stylesheet" href="<?= Yii::app()->request->baseurl; ?>/assets/kadmin/styles/jquery.news-ticker.css">
    <link type="text/css" rel="stylesheet" href="<?= Yii::app()->request->baseurl; ?>/css/custom.css">
</head>
<body>
    <div>
        <div id="wrapper">
            <!--BEGIN PAGE WRAPPER-->
            <div id="page-wrapper" class="without-margin">
                <!--BEGIN CONTENT-->
                <div class="page-content login-panel">
                    <?php echo $content; ?>
                </div>
                <!--END CONTENT-->
                <!--BEGIN FOOTER-->
                <div id="footer">
                    <div class="copyright">
                        <a href="http://themifycloud.com">2014 © KAdmin Responsive Multi-Purpose Template</a></div>
                </div>
                <!--END FOOTER-->
            </div>
            <!--END PAGE WRAPPER-->
        </div>
    </div>
</body>
</html>
