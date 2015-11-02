<?php
/*
 * MyApp Sample application for Pokelio PHP Framework
 *
 * (c) A. Iriberri <betuto92 (at) gmail.com>
 *
 */
/**
 * App.php
 * Entry point of consumer application
 * 
 * @author A. Iriberri <betuto92 (at) gmail.com>
 */
/*
 * Require Pokelio Application Class File
 * Use a relative or absolute path to it
 * Tipically, Pokelio is at the same directory level than the consumer app
 * i.e.:
 * require '../PokelioFW/Core/Classes/Application/Application.php';
 */
require '../Pokelio/Core/Classes/Application/Application.php';

/*
 * New instance of Pokelio Application for this application
 * 1st argument
 *   Pass the config files (Pokelio and modules) absolute path as a parameter to 
 *   the construct method of Application class
 *   i.e.:
 *     $configFile=realpath('../FWMyAppConfig');
 * 2nd argument
 *   Pass the absolute path of this application
 *   i.e.:
 *     $appRealPath=realpath(__DIR__);
 * 
 *     
 */
$configPath=realpath('../CLTV/Config');
$appRealPath=realpath(__DIR__);

$app = new Pokelio_Application($configPath, $appRealPath);

/*****************************************************************
 *                                                               *
 *    DO NOT WRITE ANY CODE BELOW THIS POINT                     *
 *    Change the START_POINT entry of config file to specify     *
 *    the Application starting point.                            *
 *                                                               *
 *****************************************************************/
