<?php

namespace Nether\Project\Config;

use \Nether;

class Directory extends Option {

	public function Execute(Nether\Project\RealBooter $realbooter) {

		$path = $realbooter->GetFullPathTo($this->Value);
		$result = true;

		echo "[Directory] Creating {$path}", PHP_EOL;

		if(!file_exists($path)) {
			$umask = umask(0);
			$result = mkdir($path,0777,true);
			umask($umask);
		}

		return $result;
	}

}
