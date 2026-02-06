@echo off
REM Script para actualizar URLs del sitemap
REM Uso: actualizar-sitemap.bat tu-dominio.com

if "%1"=="" (
    echo Error: Debes proporcionar un dominio
    echo Uso: actualizar-sitemap.bat tu-dominio.com
    exit /b 1
)

powershell -Command "(Get-Content sitemap.xml) -replace 'https://TU-DOMINIO.com/', 'https://%1/' | Set-Content sitemap.xml"
powershell -Command "(Get-Content robots.txt) -replace 'https://barcelonenses.com/', 'https://%1/' | Set-Content robots.txt"

echo Sitemap actualizado con el dominio: %1
pause
