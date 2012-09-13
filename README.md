TwitterClone - Kviddevitter
---------------------------

När jag kör projektet lokalt så använder jag apache-servern XAMPP

1. Placera projektmappen på lämpligt ställe i C:\xampp\htdocs


2. Sätt upp en virtual host för projektmappen. Lägg till följande i filen C:\xampp\apache\conf\extra\httpd-vhost.conf:

NameVirtualHost *:80

<VirtualHost *:80>
	ServerName kviddevitter.local
	DocumentRoot "sökväg till projektets public-mapp"
	
	SetEnv APPLICATION_ENV "development"
	
	<Directory "sökväg till projektets public-mapp">
		DirectoryIndex index.php
		AllowOverride All
		Order allow,deny
		Allow from all
	</Directory>
</VirtualHost>


3. Importera localhost.sql i phpmyadmin


4. Sätt lösenord på databasen och se till att namnet och lösenordet matchar det som står i application.ini


5. Gå till lämplig webbläsare och skriv localhost i adressfältet.