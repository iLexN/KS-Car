<?php
session_start();
if ( !isset($_SESSION['login']) && !$_SESSION['login']) {
      header('Location: login.php');
  }
?>
<!DOCTYPE html>
<html>
<head>
    <title>Kwiksure - Rule Setting Panel</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css/normalize.css" rel="stylesheet" type="text/css" />
    <link href="css/main.css" rel="stylesheet" type="text/css" />
    <link href="css/css-v2.css" rel="stylesheet" type="text/css" />
</head>
<body id="app">

    <div class="alertNote"></div>

    <!-- DetailsInfoPanel Start-->
    <?php include('chunk2/panel/details-info-panel.html'); ?>
    <!-- DetailsInfoPanel End-->

    <!-- OccupationPanel Start-->
    <?php include('chunk2/panel/occupation-panel.html'); ?>
    <!-- OccupationPanel End-->

    <!-- CarPanel Start-->
    <?php include('chunk2/panel/car-panel.html'); ?>
    <!-- CarPanel End-->

    <?php include('chunk2/top-nav.html'); ?>

    <div class="clearfix" >

        <!-- left-side start -->
        <div class="left-side">
            <?php include('chunk2/left-side.html');?>
        </div>
        <!-- left-side end -->


        <!-- right-side start -->
        <div class='right-side'>
            <h1 style="padding: 0;margin:0;color:#C82A2F">{{rule.rule_name}}</h1>
            <?php include('chunk2/tab-nav.html');?>
            <?php include('chunk2/tab/setting-tab.html');?>
            <?php include('chunk2/tab/ncd-tab.html');?>
            <?php include('chunk2/tab/make-model-tab.html');?>
            <?php include('chunk2/tab/occupation-tab.html');?>
            <?php include('chunk2/tab/details-info-tab.html');?>
            <?php include('chunk2/tab/sub-plan-tab.html');?>
        </div>
        <!-- right-side end -->
    </div>

    <div style="height:50px;"></div>

    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/vue/1.0.25/vue.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.9.1/axios.min.js"></script>
    <script src="js/app.js" type="text/javascript"></script>
</body>
</html>
