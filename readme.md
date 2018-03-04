What is CI HDGROUP
---

-  Softwar Application berbasis Web Responsif yang dibuat menggunakan Bahasa Pemrograman PHP dengan Framework Codeigniter. Kenapa Codeigniter? karena Codeigniter salah satu Framework PHP yg simple & ringan, dan termasuk salah satu Framework PHP tercepat. [benchmark1](https://www.nixsolutions.com/blog/comparative-testing-php-frameworks/) - [benchmark2](https://github.com/kenjis/php-framework-benchmark).   

-  Didukung oleh Database PostgreSQL untuk scalability & performance yg baik & mumpuni. 
-  Dan didukung juga oleh NGINX Web Server yang terkenal cepat, ringan & powerfull.  

Server Requirements
---

- NGINX version 1.13.8 or newer.
- PHP version 7.1.9 or newer is recommended.
- PostgreSQL version 10.2 or newer.

Installation
---

For Windows:

1. Instalasi Webserver. [Instalasi NGINX & PHP di Windows untuk Codeigniter](https://github.com/antho-firuze/windows-nginx-php-ci)

	Settingan untuk file PHP.ini:
	```bash
	extension=php_pdo_pgsql.dll
	extension=php_pgsql.dll
	extension=php_gd2.dll
	extension=php_mbstring.dll
	extension=php_openssl.dll
	extension=php_com_dotnet.dll
	```
  
2. Instalasi Database PostgreSQL.  [Download](https://www.postgresql.org/download/windows/)
3. Instalasi Composer untuk mendownload Dependencies yg dibutuhkan: [Download](https://getcomposer.org/Composer-Setup.exe).
   Buka command prompt, masuk ke folder ci_hdgroup, setelah itu jalankan perintah ``composer update``
4. Restore Database, jalankan file ``pgrestore.bat`` di dalam folder database.
5. Done

Contact
---
- Jika ada pertanyaan, kontak saya melalui [Facebook](https://www.facebook.com/antho.firuze) ~ [Email](mailto:antho.firuze@gmail.com)
