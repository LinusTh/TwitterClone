TwitterClone - Kviddevitter
---------------------------

N�r jag k�r projektet lokalt s� anv�nder jag apache-servern XAMPP

1. Placera projektmappen p� l�mpligt st�lle i C:\xampp\htdocs


2. S�tt upp en virtual host f�r projektmappen. L�gg till f�ljande i filen C:\xampp\apache\conf\extra\httpd-vhost.conf:

NameVirtualHost *:80

<VirtualHost *:80>
	ServerName kviddevitter.local
	DocumentRoot "s�kv�g till projektets public-mapp"
	
	SetEnv APPLICATION_ENV "development"
	
	<Directory "s�kv�g till projektets public-mapp">
		DirectoryIndex index.php
		AllowOverride All
		Order allow,deny
		Allow from all
	</Directory>
</VirtualHost>


3. Importera localhost.sql i phpmyadmin


4. S�tt l�senord p� databasen och se till att namnet och l�senordet matchar det som st�r i application.ini


5. G� till l�mplig webbl�sare och skriv localhost i adressf�ltet.