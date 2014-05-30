<?php

namespace Nether\Project;

use \Exception;
use \Nether;

class RealBooter {

	public $ProjectRoot;
	/*//
	@type string
	the directory this project will be built in.
	//*/

	public $Config = [];
	/*//
	@type array
	all the config options the user opted to act upon.
	//*/

	////////////////
	////////////////

	public function __construct() {
		$this->ProjectRoot = getcwd();
		return;
	}

	////////////////
	////////////////

	public function AddConfigOption($option) {
		if(!$option->Use) return;
		$this->Config[$option->Name] = $option;
		return;
	}

	public function GetFullPathTo($dir) {
		return sprintf(
			'%s%s%s',
			$this->ProjectRoot,
			DIRECTORY_SEPARATOR,
			$dir
		);
	}

	////////////////
	////////////////

	static function QueryYesOrNo() {
		$result = false;

		while(!$result) {
			echo '[y/n]: ';
			$result = strtolower(trim(fgets(STDIN)));
		}

		if($result === 'y') return true;
		else return false;
	}

	////////////////
	////////////////

	public function Begin() {
		echo PHP_EOL;
		echo "Nether Real Booting Agent", PHP_EOL;
		echo "ProjectRoot: {$this->ProjectRoot}", PHP_EOL, PHP_EOL;
		echo "Hit enter to continue.", PHP_EOL;
		fgets(STDIN);
		return;
	}

	public function End() {
		echo PHP_EOL;
		echo "Done.", PHP_EOL, PHP_EOL;
		echo wordwrap("If you specified any autoloading namespaces you need to run composer dump-autoload to have it regenerate its magic stuff. Depending on your system can do that a few ways. Choose the way that is most like how you installed Nether to begin with.",70), PHP_EOL, PHP_EOL;
		echo "   * php composer.phar dump-autoload", PHP_EOL;
		echo "   * composer dump-autoload", PHP_EOL;
		return;
	}

	public function Aborted() {
		echo PHP_EOL;
		echo "Aborted.", PHP_EOL, PHP_EOL;
		return;
	}

	public function Save() {
		$filepath = $this->GetFullPathTo('nether.json');
		file_put_contents(
			$filepath,
			json_encode($this->Config,JSON_PRETTY_PRINT)
		);
	}

	public function Confirm() {
		echo PHP_EOL;
		echo "Run with these settings?", PHP_EOL;

		foreach($this->Config as $option) {
			echo " - {$option->Name} = {$option->Value}", PHP_EOL;
		}

		return self::QueryYesOrNo();
	}

	public function Execute() {
		reset($this->Config);
		echo PHP_EOL;

		foreach($this->Config as $option) {
			$option->Execute($this);
		}

		return;
	}

}
