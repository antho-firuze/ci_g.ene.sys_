=====================================================
	README FOR SETUP APPLICATION ON SERVER
=====================================================
	PREPARATION:
=====================================================
- Install XAMPP Version 7.0.15
- Install PostgreSQL 9.4
- Install Database Connectivity/Extension in PHP.ini:

	- PostgreSQL 9.4:
		extension=php_pdo_pgsql.dll
		extension=php_pgsql.dll
		
	- Ms SQL Server 2013:
		extension=php_sqlsrv_7_ts_x86.dll
		extension=php_pdo_sqlsrv_7_ts_x86.dll
		
- Enable Extension for Office/Windows Shell:
	extension=php_com_dotnet.dll

- Install Composer, and running command: "Composer update"

- A little tweak for vendor "vendor\phpoffice\phpexcel\Classes\PHPExcel\Writer\PDF\mPDF.php"
	old:
			
			$pdf = new mpdf();
			
	new: (since mPDF version 7.0)
	
			$pdf = new \Mpdf\Mpdf();
			
=====================================================
	DONE !
=====================================================
