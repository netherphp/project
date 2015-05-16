Nether Project
==============

A CLI utility for getting a new project up and running really damn fast.

Start yourself with an empty folder. If you do not have Composer installed system-wide, then grab your composer.phar and put it in your new empty directory. Then install Nether Project.

	$ php composer.phar require netherphp/project ~1.0
	
This will create a vendor directory, a composer.json, and a composer.lock file. Now run the Nether Project Realbooting Agent to create application scaffolding.
	
	$ php vendor/bin/nether-realboot
	
When it is all done it will tell you things. The most important thing it will tell you is that you will need to run composer update to actually install the additional components that were enabled by the realbooting agent.

	$ php composer.phar update

Another thing it may tell you is, if you enabled Nether Avenue (which is default to yes) then you can instantly see the application working in your web browser by running the PHP bulit in test server.

	$ php -S localhost:80 -t www


Install
-------

Use Composer.

	"require": { "netherphp/project":"~1.0" }

Usage
-----

Install Nether Project and whatever else.

	composer install

Run the Real Booting Agent.

	Windows: vendor\bin\nether-realboot
	Not Windows: php vendor/bin/nether-realboot

Hit enter a few times, huzzah. It'll tell you what to do next.
