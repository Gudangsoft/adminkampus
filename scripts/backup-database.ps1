# Database Backup Script for G0-CAMPUS
# Usage: .\scripts\backup-database.ps1

# Get current timestamp
$timestamp = Get-Date -Format "yyyyMMdd_HHmmss"

# Database configuration
$dbHost = "127.0.0.1"
$dbPort = "3306"
$dbName = "g0_campus"
$dbUser = "root"

# Backup directory
$backupDir = "storage\backups"

# Create backup directory if it doesn't exist
if (!(Test-Path $backupDir)) {
    New-Item -ItemType Directory -Path $backupDir -Force
    Write-Host "Created backup directory: $backupDir"
}

# Generate backup filename
$backupFile = "$backupDir\g0_campus_backup_$timestamp.sql"

Write-Host "Starting database backup..."
Write-Host "Database: $dbName"
Write-Host "Timestamp: $timestamp"

try {
    # Create backup
    Write-Host "Creating backup..."
    
    mysqldump -u $dbUser -h $dbHost --port=$dbPort --single-transaction --routines --triggers $dbName > $backupFile
    
    if (Test-Path $backupFile) {
        $fileSize = (Get-Item $backupFile).Length
        $fileSizeKB = [math]::Round($fileSize / 1KB, 2)
        Write-Host "Backup created successfully: $backupFile ($fileSizeKB KB)"
        
        # Create compressed version
        Write-Host "Creating compressed backup..."
        $compressedFile = "$backupFile.gz"
        mysqldump -u $dbUser -h $dbHost --port=$dbPort --single-transaction --routines --triggers $dbName | gzip > $compressedFile
        
        if (Test-Path $compressedFile) {
            $compressedSize = (Get-Item $compressedFile).Length
            $compressedSizeKB = [math]::Round($compressedSize / 1KB, 2)
            Write-Host "Compressed backup created: $compressedFile ($compressedSizeKB KB)"
        }
        
        Write-Host "Backup completed successfully!"
        
    } else {
        Write-Host "Backup failed - file not created"
        exit 1
    }
    
} catch {
    Write-Host "Backup failed: $($_.Exception.Message)"
    exit 1
}

Write-Host "Database backup process completed!"
