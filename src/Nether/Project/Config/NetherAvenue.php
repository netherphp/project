<?php

namespace Nether\Project\Config;

use \Nether;

class NetherAvenue extends Option {

	public function Execute(Nether\Project\RealBooter $realbooter) {
		if(strtolower($this->Value) !== 'y') return;
		if(!$this->Use) return;

		$this->CopyIndexFile($realbooter);
		$this->CopyRoutes($realbooter);

		return true;
	}

	protected function CopyIndexFile($realbooter) {
		$oldfile = sprintf(
			'%s/packages/avenue/www/index.php',
			APP_ROOT
		);

		$newfile = sprintf(
			'%s/index.php',
			$realbooter->GetFullPathTo($realbooter->Config['WebDirectory']->Value)
		);

		// how far did they try to bury the web directory?
		$bury = 1 + count(explode(DIRECTORY_SEPARATOR,preg_replace(
			'/[\/\\\\]/',
			DIRECTORY_SEPARATOR,
			$realbooter->Config['ConfigDirectory']->Value
		)));

		$open = str_repeat('dirname(',$bury);
		$close = str_repeat(')',$bury);

		// update the include of start.php in it
		$data = str_replace(
			'%PORTABLE_PROJECT_ROOT%',
			sprintf(
				"%s__FILE__%s",
				$open,
				$close
			),
			file_get_contents($oldfile)
		);

		// save it out.
		file_put_contents($newfile,$data);

		return true;
	}

	protected function CopyRoutes($realbooter) {

		$sourcedir = sprintf(
			'%1$s%2$spackages%2$savenue%2$score',
			APP_ROOT,
			DIRECTORY_SEPARATOR
		);

		$destdir = $realbooter->GetFullPathTo(
			$realbooter->Config['AutoloadDirectory']->Value
		);

		Nether\Project\RealBooter::CopyDirectory($sourcedir,$destdir);

		return true;
	}

}
