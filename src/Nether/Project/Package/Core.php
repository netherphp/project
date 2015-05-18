<?php

namespace Nether\Project\Package;
use \Nether;

class Core extends Nether\Project\Package {

	protected $Name = 'Nether Core';
	protected $Version = '(required)';
	protected $Enabled = true;

	////////////////////////////////
	////////////////////////////////

	public function Setup(Nether\Project\RealBooter $realboot) {

		$this
		->Setup_CreateConfigRoot($realboot);

		return $this;
	}

	public function Setup_CreateConfigRoot($realboot) {

		$realboot
		->CreateProjectDirectory('conf')
		->InstallProjectFile('Core/conf-start.txt','conf/start.php');


		return $this;
	}

	////////////////////////////////
	////////////////////////////////

	public function Finish(Nether\Project\RealBooter $realboot) {

		$realboot->ShowMessage('To finalise your setup you will need to run composer update to make sure you have all the packages and get your autoloader generated.');
		echo "\t$ php composer.phar update", PHP_EOL, PHP_EOL;

		$realboot->ShowMessage('If you already had all the packages installed prior (manually or via netherphp/world) or are having issues with undefined classes, try regenerating the autoloader.');
		echo "\t$ php composer.phar dump-autoload", PHP_EOL, PHP_EOL;

		return;
	}

}

