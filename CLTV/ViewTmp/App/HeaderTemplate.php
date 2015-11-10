<!DOCTYPE html>
<html lang="<?php echo $htmlLang; ?>">
    <head>
        <meta charset="<?php echo $htmlCharset; ?>" />
        <title><?php echo $pageTitle; ?></title>
        <!-- Package inclusion -->
        <!-- jQuery http://jquery.com/ -->
        <script src="<?php echo $rscUrl; ?>/Vendors/jQuery/jquery-2.1.4.min.js"></script>
        
        <!-- Pokelio -->
        <script src="<?php echo $rscUrl; ?>/Vendors/Pokelio/js/pokelio.js"></script>
        
        <!-- easyui http://www.jeasyui.com/ -->
        <!--
        <link rel="stylesheet" href="<?php echo $rscUrl; ?>/Vendors/easyui/themes/default/easyui.css">
        <link rel="stylesheet" href="<?php echo $rscUrl; ?>/Vendors/easyui/themes/icon.css">
        <script src="<?php echo $rscUrl; ?>/Vendors/easyui/jquery.easyui.min.js"></script>
        -->
        
        <!-- jQuery UI http://jqueryui.com/ -->
        <!--
        <link rel="stylesheet" href="<?php echo $rscUrl; ?>/Vendors/jQueryUI/jquery-ui.min.css">
        <link rel="stylesheet" href="<?php echo $rscUrl; ?>/Vendors/jQueryUI/jquery-ui.theme.min.css">
        <script src="<?php echo $rscUrl; ?>/Vendors/jQueryUI/jquery-ui.min.js"></script>
        -->  
        
        <!-- Bootstrap http://getbootstrap.com/ -->
        <!--
        <link rel="stylesheet" href="<?php echo $rscUrl; ?>/Vendors/Bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="<?php echo $rscUrl; ?>/Vendors/Bootstrap/css/bootstrap-theme.min.css">
        <script src="<?php echo $rscUrl; ?>/Vendors/Bootstrap/js/bootstrap.min.js"></script>
        -->
        
        <!-- Materialize http://materializecss.com// -->
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link rel="stylesheet" href="<?php echo $rscUrl; ?>/Vendors/Materialize/css/materialize.min.css">
        <script src="<?php echo $rscUrl; ?>/Vendors/Materialize/js/materialize.min.js"></script>
                
        
        <!-- CSS section -->
        <?php foreach($htmlCss as  $cssFile){ ?>
        <link rel="stylesheet" href="<?php echo $cssFile; ?>" type="text/css" />
        <?php } ?>
        <!-- JS section -->
        
        <?php foreach($htmlJs as  $jsFile){ ?>
        <script src="<?php echo $jsFile; ?>"></script>
        <?php } ?>
    </head>

    <body id="body" class="home">
        