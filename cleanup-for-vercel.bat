@echo off
REM Cleanup script untuk optimasi deployment ke Vercel (Windows)
REM Usage: cleanup-for-vercel.bat

echo.
echo ================================================================================
echo    ZENIRO STORE - VERCEL DEPLOYMENT CLEANUP
echo ================================================================================
echo.

setlocal enabledelayedexpansion

REM 1. Remove vendor folder
if exist vendor (
    echo Removing vendor folder...
    rmdir /s /q vendor 2>nul
    echo [OK] vendor folder removed
)

REM 2. Remove node_modules folder
if exist node_modules (
    echo Removing node_modules folder...
    rmdir /s /q node_modules 2>nul
    echo [OK] node_modules folder removed
)

REM 3. Clear bootstrap cache
if exist bootstrap\cache (
    echo Cleaning bootstrap cache...
    del /q bootstrap\cache\* 2>nul
    echo [OK] bootstrap cache cleared
)

REM 4. Clear old logs
if exist storage\logs (
    echo Cleaning logs...
    del /q storage\logs\*.log 2>nul
    echo [OK] logs cleared
)

echo.
echo ================================================================================
echo    SUMMARY
echo ================================================================================
echo.
echo [✓] vendor folder removed (akan di-install di Vercel)
echo [✓] node_modules removed (akan di-install di Vercel)
echo [✓] Bootstrap cache cleared
echo [✓] Old logs cleared
echo.
echo ⚠️  REMINDER:
echo    1. Pastikan .gitignore contains: vendor dan node_modules
echo    2. Optimize images di public/img jika ukuran masih besar
echo    3. Check .vercelignore sudah configured dengan benar
echo.
echo 📤 Siap untuk deploy: git push
echo.
pause
