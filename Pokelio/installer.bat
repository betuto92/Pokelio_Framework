@echo off
SET mypath=%~dp0
echo %mypath:~0,-1%
php %mypath:~0,-1%/pokelio.php "controller=Deployer_Installer" "action=Install" %1 %2 %3 %4 %5 %6 %7 %8 %9