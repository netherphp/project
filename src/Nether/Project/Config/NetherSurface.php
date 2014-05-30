<?php

namespace Nether\Project\Config;

use \Nether;

class NetherSurface extends Option {

	public function Execute(Nether\Project\RealBooter $realbooter) {
		if(strtolower($this->Value) !== 'y') return;
		if(!$this->Use) return;

		$this->CopyTheme($realbooter);

		return true;
	}

	protected function CopyTheme($realbooter) {

		$sourcedir = sprintf(
			'%1$s%2$spackages%2$ssurface%2$swww',
			APP_ROOT,
			DIRECTORY_SEPARATOR
		);

		$destdir = $realbooter->GetFullPathTo(
			$realbooter->Config['WebDirectory']->Value
		);

		Nether\Project\RealBooter::CopyDirectory($sourcedir,$destdir);

		return true;
	}

}
