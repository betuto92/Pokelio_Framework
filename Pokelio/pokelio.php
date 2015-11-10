<?php

require __DIR__.'/Core/Classes/Pokelio/Pokelio.php';

$configPath=realpath(__DIR__.'/Config');
$appRealPath=realpath(__DIR__);

$app = new Pokelio_Pokelio($configPath, $appRealPath);

