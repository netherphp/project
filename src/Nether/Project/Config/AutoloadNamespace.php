<?php

namespace Nether\Project\Config;

use \Nether;

class AutoloadNamespace extends Option {

	public function Execute(Nether\Project\RealBooter $realbooter) {
		if(!$this->Use && $this->Value) return;
		if(!array_key_exists('AutoloadDirectory',$realbooter->Config)) return;

		// find our directory.
		$dir = $realbooter->Config['AutoloadDirectory']->Value;

		// break up and trim the namespaces.
		$namespaces = explode(',',$this->Value);
		foreach($namespaces as $key => $ns) {
			$ns = trim($ns);

			if(!$ns) unset($namespaces[$key]);
			else $namespaces[$key] = $ns;
		}

		// add the default Nether Avenue namespace if enabled.
		if(array_key_exists('NetherAvenue',$realbooter->Config)) {
			$namespaces[] = 'Routes';
		}

		// find the composer file.
		$composerfile = $realbooter->GetFullPathTo('composer.json');

		if(!file_exists($composerfile)) {
			$composer = [];
		} else {
			$composer = json_decode(file_get_contents($composerfile),true);
			if(!is_array($composer)) $composer = [];
		}

		// check that it has autoload.
		if(!array_key_exists('autoload',$composer))
		$composer['autoload'] = [];

		// check that it has autoload\psr-0
		if(!array_key_exists('psr-0',$composer['autoload']))
		$composer['autoload']['psr-0'] = 0;

		// add our autoloads to composer.
		foreach($namespaces as $ns) {
			$nskey = "{$ns}\\";
			$nsdir = "{$dir}/";
			$nspath = $realbooter->GetFullPathTo(sprintf(
				'%s%s%s',
				$dir,
				DIRECTORY_SEPARATOR,
				$ns
			));

			echo "[Autoloader] Registering {$ns} with Composer", PHP_EOL;

			// add it to composer
			if(!array_key_exists($nskey,$composer['autoload']['psr-0']))
			$composer['autoload']['psr-0'][$nskey] = $nsdir;

			// create the directory
			if(!file_exists($nspath)) {
				echo "[Directory] Creating {$nspath}", PHP_EOL;
				$umask = umask(0);
				mkdir($nspath,0777,true);
				umask($umask);
			}
		}

		// write our composer.json back out.
		file_put_contents(
			$composerfile,
			json_encode($composer,JSON_PRETTY_PRINT)
		);

		return true;
	}


}
