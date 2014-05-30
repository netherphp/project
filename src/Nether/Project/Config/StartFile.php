<?php

namespace Nether\Project\Config;

use \Nether;

class StartFile extends Option {

	public function Execute(Nether\Project\RealBooter $realbooter) {
		if(!$this->Use || $this->Value !== 'y') return;
		if(!array_key_exists('ConfigDirectory',$realbooter->Config)) return;

		$startfile = $realbooter->GetFullPathTo(sprintf(
			'%s%s%s',
			$realbooter->Config['ConfigDirectory']->Value,
			DIRECTORY_SEPARATOR,
			'start.php'
		));

		ob_start(); {{{
			echo '<?php', PHP_EOL, PHP_EOL;

			if($this->GenerateProjectRoot($realbooter))
			$this->GenerateCommentBar();

			if($this->GenerateComposerAutoloader())
			$this->GenerateCommentBar();

			if($this->GenerateNetherOption($realbooter))
			$this->GenerateCommentBar();

			if($this->GenerateNetherLoaders($realbooter))
			$this->GenerateCommentBar();

			echo PHP_EOL;
		}}} $startdata = ob_get_clean();

		file_put_contents($startfile,$startdata);
	}

	protected function GenerateCommentBar() {
	/*//
	generate a comment separator bar for visualness.
	//*/

		echo '////////////////', PHP_EOL;
		echo '////////////////', PHP_EOL;
		echo PHP_EOL;
	}

	protected function GenerateProjectRoot($realbooter) {
	/*//
	@argv Nether\Project\RealBooter RealBooter
	generate a portable PROJECT_ROOT constant that should just always work
	even if the entire project moves to another place.
	//*/

		// how many directories did they try to bury the config dir?
		$confdir = explode(DIRECTORY_SEPARATOR,preg_replace(
			'/[\/\\\\]/',
			DIRECTORY_SEPARATOR,
			$realbooter->Config['ConfigDirectory']->Value
		));

		$bury = 1 + count($confdir);

		$open = str_repeat('dirname(',$bury);
		$close = str_repeat(')',$bury);

		printf(
			'define(\'PROJECT_ROOT\',%s__FILE__%s);',
			$open,
			$close
		);

		echo PHP_EOL, PHP_EOL;

		return true;
	}

	protected function GenerateComposerAutoloader() {
	/*//
	generate the include for the composer autoload file.
	//*/

		echo "require(sprintf(", PHP_EOL;
		echo "\t'%s/vendor/autoload.php',", PHP_EOL;
		echo "\tPROJECT_ROOT", PHP_EOL;
		echo "));", PHP_EOL;
		echo PHP_EOL;

		return true;
	}

	protected function GenerateNetherOption($realbooter) {
	/*//
	generate a block of Nether\Option::Set() if it was installed.
	//*/

		if(!class_exists('Nether\\Option')) return false;

		$options = [];

		// if a web directory was configured define the nether-web options so
		// that Nether Surface will Just Work.
		if(array_key_exists('WebDirectory',$realbooter->Config)) {
			$options[] = "'nether-web-root' => sprintf('%s/{$realbooter->Config['WebDirectory']->Value}',PROJECT_ROOT)";
			$options[] = "'nether-web-path' => '/'";
		}

		echo "Nether\\Option::Set([", PHP_EOL;
		echo "\t";
		echo implode(",".PHP_EOL."\t",$options);
		echo PHP_EOL;
		echo "]);", PHP_EOL;
		echo PHP_EOL;

		return true;
	}

	protected function GenerateNetherLoaders($realbooter) {
	/*//
	generate the calls to prompt any nether loading.
	//*/

		$anything = false;

		if(array_key_exists('NetherSurface',$realbooter->Config)) {
			$anything = true;
			echo "new Nether\Surface;", PHP_EOL;
		}

		if(array_key_exists('NetherCache',$realbooter->Config)) {
			$anything = true;
			echo "new Nether\Cache;", PHP_EOL;
		}

		if($anything) {
			echo PHP_EOL;
			return true;
		} else {
			return false;
		}

	}

}
