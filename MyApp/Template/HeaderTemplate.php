<!DOCTYPE html>
<html lang="<m>$htmlLang</m>">
    <head>
        <meta charset="<m>$htmlCharset</m>" />
        <title><m>$pageTitle</m></title>
        <!-- Package inclusion -->
        <!-- jQuery http://jquery.com/ -->
        <script src="<m>$rscUrl</m>/Vendors/jQuery/jquery-2.1.4.min.js"></script>
        
        <!-- Pokelio -->
        <script src="<m>$rscUrl</m>/Vendors/Pokelio/js/pokelio.js"></script>
        
        <!-- easyui http://www.jeasyui.com/ -->
        <!--
        <link rel="stylesheet" href="<m>$rscUrl</m>/Vendors/easyui/themes/default/easyui.css">
        <link rel="stylesheet" href="<m>$rscUrl</m>/Vendors/easyui/themes/icon.css">
        <script src="<m>$rscUrl</m>/Vendors/easyui/jquery.easyui.min.js"></script>
        -->
        
        <!-- jQuery UI http://jqueryui.com/ -->
        <!--
        <link rel="stylesheet" href="<m>$rscUrl</m>/Vendors/jQueryUI/jquery-ui.min.css">
        <link rel="stylesheet" href="<m>$rscUrl</m>/Vendors/jQueryUI/jquery-ui.theme.min.css">
        <script src="<m>$rscUrl</m>/Vendors/jQueryUI/jquery-ui.min.js"></script>
        -->  
        
        <!-- Bootstrap http://getbootstrap.com/ -->
        <!--
        <link rel="stylesheet" href="<m>$rscUrl</m>/Vendors/Bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="<m>$rscUrl</m>/Vendors/Bootstrap/css/bootstrap-theme.min.css">
        <script src="<m>$rscUrl</m>/Vendors/Bootstrap/js/bootstrap.min.js"></script>
        -->
        
        <!-- Materialize http://materializecss.com// -->
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <!-- <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet"> -->
        <link rel="stylesheet" href="<m>$rscUrl</m>/Vendors/Google/Fonts/Material+Icons/Material+Icons.css">
        <link rel="stylesheet" href="<m>$rscUrl</m>/Vendors/Materialize/css/materialize.min.css">
        <script src="<m>$rscUrl</m>/Vendors/Materialize/js/materialize.min.js"></script>
                
        
        <!-- CSS section -->
        <m>for($htmlCss, $cssFile)</m>
        <link rel="stylesheet" href="<m>$cssFile</m>" type="text/css" />
        <m>}</m>
        <!-- JS section -->
        
        <m>for($htmlJs, $jsFile)</m>
        <script src="<m>$jsFile</m>"></script>
        <m>}</m>
    </head>
    <script>
        $(document).ready(function(){
            //Enable menu button for mobile
            $(".button-collapse").sideNav();
        });
    </script>    
    <body>
        <header>
            <nav>
                <div class="nav-wrapper light-green">
                    <a href="#" class="brand-logo">Logo</a>
                    <a href="#" data-activates="mobile-demo" class="button-collapse"><i class="material-icons">menu</i></a>
                    <ul id="dropdown1" class="dropdown-content">
                        <li><a href="#!">one</a></li>
                        <li><a href="#!">two</a></li>
                        <li class="divider"></li>
                        <li><a href="#!">three</a></li>
                    </ul>
                    <ul id="nav-mobile" class="right hide-on-med-and-down">
                      <li class="active"><a href="sass.html">Home</a></li>
                      <li><a class="dropdown-button" href="#!" data-activates="dropdown1">Documentation<i class="material-icons right">arrow_drop_down</i></a></li>
                      <li><a href="collapsible.html">Downloads</a></li>
                      <li><a href="collapsible.html">Contact</a></li>
                    </ul>
                    <ul class="side-nav" id="mobile-demo">
                        <li><a href="sass.html">Home</a></li>
                        <li><a href="badges.html">Documentation</a></li>
                        <li><a href="collapsible.html">Downloads</a></li>
                        <li><a href="mobile.html">Contact</a></li>
                    </ul>
                </div>
            </nav>  
        </header>
        <main>
        