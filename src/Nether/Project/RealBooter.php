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

	public function Welcome() {

		echo PHP_EOL;
		echo "Nether Real Booting Agent", PHP_EOL;
		echo "ProjectRoot: {$this->ProjectRoot}", PHP_EOL, PHP_EOL;
		echo "Hit enter to continue.", PHP_EOL;
		fgets(STDIN);

		return;
	}

	public function Confirm() {

		echo PHP_EOL;
		echo "Run with these settings?", PHP_EOL;

		foreach($this->Config as $option) {
			echo " - {$option->Name} = {$option->Value}", PHP_EOL;
		}

		echo PHP_EOL;

		$response = false;
		while(!$response) {
			echo "[y/n]: ";
			$response = trim(fgets(STDIN));
		}

		if($response === 'y') return true;
		else return false;
	}

	public function Execute() {
		reset($this->Config);

		foreach($this->Config as $option) {
			$option->Execute($this);
		}

		return;
	}

}
