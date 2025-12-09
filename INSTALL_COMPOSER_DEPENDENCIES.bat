@echo off
echo Installing Composer Dependencies...
echo.

cd /d "%~dp0"

REM Check if composer.phar exists
if exist composer.phar (
    echo Using existing composer.phar...
    php composer.phar install
) else (
    echo Downloading Composer...
    php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
    php composer-setup.php
    php composer.phar install
    del composer-setup.php
)

echo.
echo Installation complete!
pause
