<?php

namespace Nether\Project\Config;

use \Nether;

class Option {

	public $Name;
	/*//
	@type string
	the name of the configuration option.
	//*/

	public $DefaultValue;
	/*//
	@type mixed
	the default value this option will use.
	//*/

	public $Value;
	/*//
	@type mixed
	what the user has set the value to.
	//*/

	public $Info;
	/*//
	@type string
	info that describes what the option does.
	//*/

	public $Use = true;
	/*//
	@type bool
	if this option should be acted upon or not.
	//*/

	public function __construct($name,$default,$info) {
		$this->Name = $name;
		$this->DefaultValue = $default;
		$this->Info = $info;
		$this->Query();
		return;
	}

	public function Query() {

		echo PHP_EOL;
		echo ">> {$this->Name}", PHP_EOL;
		echo preg_replace('/^/ms','   ',wordwrap($this->Info,70)), PHP_EOL;

		echo PHP_EOL;
		echo "   Enter dash (-) to skip.", PHP_EOL;
		echo "   [{$this->DefaultValue}]: ";

		if(!defined('NETHER_PROJECT_ACCEPT_DEFAULTS'))
		$value = trim(fgets(STDIN));

		if(defined('NETHER_PROJECT_ACCEPT_DEFAULTS') || !$value) {
			$this->Value = $this->DefaultValue;
		} elseif($value === '-') {
			$this->Use = false;
		} else {
			$this->Value = $value;
		}

		return;
	}

	public function Execute(Nether\Project\RealBooter $realbooter) {
		return;
	}

}
