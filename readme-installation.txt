=====================================================
	README FOR SETUP APPLICATION ON SERVER
=====================================================
	PREPARATION:
=====================================================
- Install XAMPP Version 7.0.15 or NGINX v1.13.5 + PHP v7.1.9-nts-Win32-VC14-x86
- Install PostgreSQL 9.6
- Install Database Connectivity/Extension in PHP.ini:
	- PostgreSQL 9.4:
		extension=php_pdo_pgsql.dll
		extension=php_pgsql.dll
		
	- Ms SQL Server 2013:
		extension=php_sqlsrv_7_ts_x86.dll
		extension=php_pdo_sqlsrv_7_ts_x86.dll
	- additional:
		extension=php_gd2.dll
		extension=php_mbstring.dll
		extension=php_openssl.dll

	- Enable Extension for Office/Windows Shell:
		extension=php_com_dotnet.dll

- Install Composer, and running command: "Composer update"

- A little tweak for vendor "vendor\phpoffice\phpexcel\Classes\PHPExcel\Writer\PDF\mPDF.php"
	old: (line 105)
			
			$pdf = new mpdf();
			
	new: (since mPDF version 7.0)
	
			$pdf = new \Mpdf\Mpdf();
			
=====================================================
	DONE !
=====================================================
