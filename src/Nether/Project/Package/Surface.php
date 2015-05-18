<?php

namespace Nether\Project\Package;
use \Nether;

class Surface extends Nether\Project\Package {

	protected $Name = 'Nether Surface';
	protected $Package = 'netherphp/surface';
	protected $Version = '~1.0.0';
	protected $Info = 'The rendering engine. Craft themes and such and have your standard output caught for the main content area. Or whatever. Installs a cheeky demo theme designed to work with Avenue if you enabled that.';

	////////////////////////////////
	////////////////////////////////

	public function Setup(Nether\Project\RealBooter $realboot) {

		$this
		->Setup_AddToComposer($realboot)
		->Setup_InstallDefaultTheme($realboot);

		return $this;
	}

	public function Setup_AddToComposer($realboot) {

		$realboot->GetComposer()
		->AddRequire($this->Package,$this->Version)
		->Save();


		return $this;
	}

	public function Setup_InstallDefaultTheme($realboot) {

		// this will be converted to be a zipfile extractor later.

		$realboot
		->CreateProjectDirectory('www')
		->CreateProjectDirectory('www/themes/default/area/home')
		->InstallProjectFile('Surface/design.phtml','www/themes/default/design.phtml')
		->InstallProjectFile('Surface/area/home/index.phtml','www/themes/default/area/home/index.phtml')
		->InstallProjectFile('Surface/area/home/about.phtml','www/themes/default/area/home/about.phtml');

		return $this;
	}

	////////////////////////////////
	////////////////////////////////

	public function Finish(Nether\Project\RealBooter $realboot) {

		return;
	}

}

