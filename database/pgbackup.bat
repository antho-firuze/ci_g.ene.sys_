@echo off
cd /D %~dp0
For /F "usebackq tokens=1,2 delims==" %%i in (`wmic os get LocalDateTime /VALUE 2^>NUL`) do if '.%%i.'=='.LocalDateTime.' set ldt=%%j
set ldt=%ldt:~0,4%%ldt:~4,2%%ldt:~6,2%_%ldt:~8,2%%ldt:~10,2%
set BACKUP_FILE=db_genesys_%ldt%.backup
rem echo backup file name is %BACKUP_FILE%
SET PGPASSWORD=Admin123
echo on
pg_dump -h localhost -p 5432 -U postgres -F c -b -v -f "%BACKUP_FILE%" db_genesys