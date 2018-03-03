What is CI HDGROUP
----

-  Softwar Application berbasis Web Responsif yang dibuat menggunakan Bahasa Pemrograman PHP dengan Framework Codeigniter. Kenapa Codeigniter? karena Codeigniter salah satu Framework PHP yg simple dan ringan dan termasuk salah satu Framework PHP tercepat `disini <https://www.nixsolutions.com/blog/comparative-testing-php-frameworks/>`_ dan `disini <https://github.com/kenjis/php-framework-benchmark>`_.   

-  Didukung oleh Database PostgreSQL untuk scalability & performance yg baik & mumpuni. 
-  Dan didukung juga oleh NGINX Web Server yang terkenal cepat, ringan & powerfull.  

Server Requirements
****

- NGINX version 1.13.8 or newer.
- PHP version 7.1.9 or newer is recommended.
- PostgreSQL version 10.2 or newer.

Installation
****

For Windows:

1. Instalasi Webserver. `Instalasi NGINX & PHP di Windows untuk Codeigniter <https://github.com/antho-firuze/windows-nginx-php-ci>`_
   
 Setting untuk file PHP.ini: 
  ``` 
  extension=php_pdo_pgsql.dll
  extension=php_pgsql.dll 
  ```
2. Instalasi Database PostgreSQL. Download `disini <https://www.postgresql.org/download/windows/>`_ 
3. Instalasi Composer untuk mendownload Dependencies yg dibutuhkan: Download Composer `disini <https://getcomposer.org/Composer-Setup.exe>`_.
   Buka command prompt, masuk ke folder ci_hdgroup, setelah itu jalankan perintah ``composer update``

