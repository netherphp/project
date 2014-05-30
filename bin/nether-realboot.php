<?php

ini_set('display_errors',true);
error_reporting(E_ALL);

require(sprintf(
	'%s/autoload.php',
	dirname(dirname(__FILE__))
));

$realbooter = new Nether\Project\RealBooter;
$realbooter->Welcome();

$realbooter->AddConfigOption(new Nether\Project\Config\Directory(
	'AutoloadDirectory', 'core',
	'This is the directory you will place the namespaces for your application (and only your application) into.'
));

if(array_key_exists('AutoloadDirectory',$realbooter->Config))
$realbooter->AddConfigOption(new Nether\Project\Config\AutoloadNamespace(
	'AutoloadNamespace', '',
	'Enter a comma separated list of namespaces you would like to register for autoloading. Enter only the base namespaces for your application. For example, if you will have a class called Foo\Bar\Derp enter "Foo". This directory will then be created in the AutoloadDirectory and your composer.json will be updated to make autoloading happen.'
));

$realbooter->AddConfigOption(new Nether\Project\Config\Directory(
	'ThirdPartyDirectory', 'share',
	'This is the directory you will place third party libraries that you may have to manually load because they did not support composer.'
));

$realbooter->AddConfigOption(new Nether\Project\Config\Directory(
	'ConfigDirectory', 'conf',
	'This is the directory you will place any configuration files you create for your application. This is also where the default start.php will be placed for you.'
));

$realbooter->AddConfigOption(new Nether\Project\Config\Directory(
	'CacheDirectory', 'cache',
	'This is the directory where you can store any cache files you need to generate and save to disk. Skip this option if you do not plan to write any cache to disk.'
));

$realbooter->AddConfigOption(new Nether\Project\Config\Directory(
	'CronDirectory', 'cron',
	'This is the directory you will place any scripts that need to be scheduled to be automatically run by your server. You will need to add any scripts you create to your crontab yourself.'
));

$realbooter->AddConfigOption(new Nether\Project\Config\Directory(
	'ToolDirectory', 'tools',
	'This is the directory you will place any command line scripts you may write to do things for your application.'
));

$realbooter->AddConfigOption(new Nether\Project\Config\Directory(
	'WebDirectory', 'www',
	'This is the directory your website will be served from. You will need to configure your webserver (Apache, nginx, whatever) to point to this directory.'
));

if($realbooter->Confirm()) {
	$realbooter->Execute();
}