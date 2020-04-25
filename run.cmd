@echo off

echo "init mysql..."
set /p user="User: "
mysql -u %user% -p < "db/database.sql"
echo "OK"

echo "init localhost..."
set /p port="Port: "
start php -S localhost:%port%
echo "OK"

pause