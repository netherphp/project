<?php

namespace Nether\Project\Package;
use \Nether;

class Avenue extends Nether\Project\Package {

	protected $Name = 'Nether Avenue';
	protected $Package = 'netherphp/avenue';
	protected $Version = '~1.0.0';
	protected $Info = 'The request routing system and core of a Nether based web stack. Avenue will analyise all incoming requests and route the traffic to the specific router that is defined to handle it.';

	////////////////////////////////
	////////////////////////////////

	protected $RouteNamespace = 'Routes';
	protected $RouteDirectory = 'routes';

	////////////////////////////////
	////////////////////////////////

	public function Setup(Nether\Project\RealBooter $realboot) {

		$this
		->Setup_AddToComposer($realboot)
		->Setup_CreateWebRoot($realboot)
		->Setup_CreateRouteRoot($realboot);

		return $this;
	}

	protected function Setup_AddToComposer($realboot) {

		$composer = $realboot->GetComposer()
		->AddRequire($this->Package,$this->Version)
		->Save();

		return $this;
	}

	protected function Setup_CreateWebRoot($realboot) {

		$realboot
		->CreateProjectDirectory('www')
		->InstallProjectFile('Avenue/www-index.txt','www/index.php');

		return $this;
	}

	protected function Setup_CreateRouteRoot($realboot) {

		$realboot
		->CreateProjectDirectory('routes')
		->InstallProjectFile('Avenue/routes-home.txt','routes/Home.php')
		->GetComposer()
			->AddAutoload4("{$this->RouteNamespace}\\","{$this->RouteDirectory}/")
			->Save();

		return $this;
	}

	////////////////////////////////
	////////////////////////////////

	public function Finish(Nether\Project\RealBooter $realboot) {

		$realboot->ShowMessage('After the composer update you will be able to test this new application right out of the box with PHPs built in test server. If you installed Nether Surface, it will even be pretty.');
		echo "\t$ php -S localhost:80 -t www", PHP_EOL, PHP_EOL;

		return;
	}

}

