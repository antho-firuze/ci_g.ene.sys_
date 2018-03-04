@echo off
SET PGPASSWORD=Admin123
echo on
dropdb -h localhost -p 5432 -U postgres db_genesys
pg_restore -h localhost -p 5432 -U postgres -C -d postgres db_genesys.backup
