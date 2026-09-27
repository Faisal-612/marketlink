@echo off
title MarketLink - eGreen Basket Local Server
color 0A

echo =====================================================================
echo       MarketLink (eGreen Basket) - Local Development Server
echo =====================================================================
echo.

:: Add PHP to PATH if not present
set "PHP_DIR=C:\Users\Developers\AppData\Local\Microsoft\WinGet\Packages\PHP.PHP.8.3_Microsoft.Winget.Source_8wekyb3d8bbwe"
if exist "%PHP_DIR%\php.exe" (
    set "PATH=%PHP_DIR%;%PATH%"
)

:: Navigate to marketlink directory if launched from parent
if exist "%~dp0marketlink" (
    cd /d "%~dp0marketlink"
) else (
    cd /d "%~dp0"
)

echo [1/3] Checking environment & database...
if not exist "database\database.sqlite" (
    echo Database file not found. Creating SQLite database...
    type nul > database\database.sqlite
    php artisan migrate --force
    php artisan db:seed --force
)

echo [2/3] Opening MarketLink in your default browser...
timeout /t 2 /nobreak >nul
start http://127.0.0.1:8000

echo [3/3] Starting Laravel Development Server on http://127.0.0.1:8000...
echo.
echo =====================================================================
echo  SERVER IS RUNNING! Press Ctrl + C to stop the server at any time.
echo ---------------------------------------------------------------------
echo  Web URL:      http://127.0.0.1:8000
echo  Admin Login:  admin@marketlink.com  ^|  password
echo  Farmer Login: greenfarms@marketlink.com  ^|  password
echo  Customer:     ali.khan@gmail.com  ^|  password
echo =====================================================================
echo.

php artisan serve --host=127.0.0.1 --port=8000

pause
