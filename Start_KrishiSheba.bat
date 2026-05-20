@echo off
title KrishiSheba Server
color 0A

echo =========================================
echo       Starting KrishiSheba Project
echo =========================================
echo.

:: Go to Laravel app directory
cd /d c:\xampp2\htdocs\KrishiSheba\laravel_app

:: Open the browser automatically
start http://127.0.0.1:8000

:: Start the Laravel Server
echo Server is running! Please DO NOT close this black window.
echo To stop the server, press Ctrl + C or close this window.
echo.
c:\xampp2\php\php.exe artisan serve

pause
