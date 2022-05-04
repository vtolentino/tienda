# tienda
Ruta del archivo a configurar para agregar el DNS a XAMPP

C:\xampp2\apache\conf\extra\httpd-vhosts.conf

Agregar siguientes lineas al final

NameVirtualHost *:80

<VirtualHost *:80>
  DocumentRoot "C:/xampp2/htdocs/tienda"
  ServerName www.tienda.local
  ServerAlias tienda.local
  <Directory "C:/xampp2/htdocs/tienda">
    AllowOverride All
    Require all Granted
    # En versiones anteriores de Apache 2.4 poner estas directivas en lugar de las 2 anteriores.
    # Order allow,deny
    # Allow from all
  </Directory>
</VirtualHost>

Ruta del archivo donde se agrega el host a la maquina local
C:\Windows\System32\drivers\etc\hosts

Agregar al final del archivo.
127.0.0.1 www.tienda.local

Reiniciar XAMPP
