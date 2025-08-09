@echo off
REM Database Backup Script for G0-CAMPUS
REM Usage: scripts\backup-database.bat

echo Starting G0-CAMPUS Database Backup...
echo.

REM Get current timestamp
for /f "tokens=1-5 delims=/ " %%a in ('date /t') do set mydate=%%c%%a%%b
for /f "tokens=1-2 delims=: " %%a in ('time /t') do set mytime=%%a%%b
set timestamp=%mydate%_%mytime%

REM Database configuration
set DB_HOST=127.0.0.1
set DB_PORT=3306
set DB_NAME=g0_campus
set DB_USER=root

REM Backup directory
set BACKUP_DIR=storage\backups
if not exist %BACKUP_DIR% mkdir %BACKUP_DIR%

REM Generate backup filename
set BACKUP_FILE=%BACKUP_DIR%\g0_campus_backup_%timestamp%.sql

echo Database: %DB_NAME%
echo Timestamp: %timestamp%
echo Output: %BACKUP_FILE%
echo.

REM Create backup
echo Creating database backup...
mysqldump -u %DB_USER% -h %DB_HOST% --port=%DB_PORT% --single-transaction --routines --triggers %DB_NAME% > %BACKUP_FILE%

if exist %BACKUP_FILE% (
    echo ✓ Backup created successfully: %BACKUP_FILE%
    
    REM Get file size
    for %%A in (%BACKUP_FILE%) do set FILESIZE=%%~zA
    set /a FILESIZE_KB=%FILESIZE%/1024
    echo   File size: %FILESIZE_KB% KB
    
    REM Create compressed backup
    echo Creating compressed backup...
    mysqldump -u %DB_USER% -h %DB_HOST% --port=%DB_PORT% --single-transaction --routines --triggers %DB_NAME% | gzip > %BACKUP_FILE%.gz
    
    if exist %BACKUP_FILE%.gz (
        echo ✓ Compressed backup created: %BACKUP_FILE%.gz
        for %%A in (%BACKUP_FILE%.gz) do set COMPRESSED_SIZE=%%~zA
        set /a COMPRESSED_KB=%COMPRESSED_SIZE%/1024
        echo   Compressed size: %COMPRESSED_KB% KB
    )
    
    echo.
    echo ✓ Database backup completed successfully!
) else (
    echo ❌ Backup failed - file not created
    exit /b 1
)

echo.
echo Files in backup directory:
dir %BACKUP_DIR% /b

echo.
echo Database backup process completed!
pause
