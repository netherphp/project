Nether Project
==============

A CLI utility for getting a new project up and running really damn fast.

Install
-------

Use Composer.

	"require": { "netherphp/world":"dev-master" }

Or if you were selective on your Nether packages, add netherphp/project instead.
Since the whole point of this is to start a project from scratch as fast and
easy as possible, I would suggest just including Nether World or at the very
least:

* Avenue (netherphp/avenue)
* Surface (netherphp/surface)

Usage
-----

Install Nether Project and whatever else.

	composer install

Run the Real Booting Agent. (omit the `php` on Windows)

	php vendor\bin\nether-realboot

Hit enter a few times to see all the settings, or run the agent with --defaults
to just accept them all and go. Some of the settings are just to make things
easier for you later, like creating a cache directory that you might not even
use. You can skip any options.

Tell composer to update its autoloader with anything you configured during
the real booting process.

	composer dump-autoload

Run PHP.

	php -S localhost:80 -t www

Hit it in your browser. Enjoy your skeleton project.

Notes
-----

To enable Nether Avenue automatically you must have enabled:

* Avenue via netherphp/world or netherphp/avenue
* Creating an autoload directory (AutoloadDirectory)
* Creating a default start.php (StartFile)

To enable Nether Surface automatically you must have enabled:

* Surface via netherphp/world or netherphp/surface
* Creating a web root directory (WebDirectory)
* Creating a default start.php (StartFile)

To enable Nether Cache automatically you must have enabled:

* Cache via netherphp/world or netherphp/cache
* Creating a default start.php (StartFile)
