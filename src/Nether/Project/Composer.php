<?php

namespace Nether\Project;
use \Nether;
use \Exception;

class Composer {

	public $Filepath;
	public $Data;

	////////////////
	////////////////

	public function __construct($filename) {

		if(!file_exists($filename))
		throw new Exception("cannot find {$filename}",1);

		if(!is_readable($filename) || !is_writable($filename))
		throw new Exception("cannot read or write {$filename}",2);

		$this->Data = json_decode(file_get_contents($filename),true);
		if(!is_array($this->Data)) $this->Data = [];

		$this->Filepath = $filename;
		return;
	}

	public function Save() {
	/*//
	write the composer file to disk in pretty json format.
	//*/

		// make things a little prettier prior.
		ksort($this->Data['require']);

		// write to disk.
		file_put_contents($this->Filepath,json_encode(
			$this->Data,
			(JSON_PRETTY_PRINT|JSON_FORCE_OBJECT)
		));

		return;
	}

	////////////////
	////////////////

	public function AddRequire($repo,$ver) {

		// make sure require exists.
		if(!array_key_exists('require',$this->Data))
		$this->Data['require'] = [];

		// add.
		echo "++ Adding {$repo} {$ver} as a project requirement.", PHP_EOL;
		$this->Data['require'][$repo] = $ver;
		return $this;
	}

	public function RemoveRequire($repo) {

		// make sure require exists.
		if(!array_key_exists('require',$this->Data))
		return $this;

		// remove.
		echo "-- Removing {$repo} from project requirements.", PHP_EOL;
		if(array_key_exists($repo,$this->Data['require']))
		unset($this->Data['require'][$repo]);

		return $this;
	}

	public function AddAutoload($type,$ns,$dir) {

		// make sure autoload exists.
		if(!array_key_exists('autoload',$this->Data))
		$this->Data['autoload'] = [];

		// make sure autoload psr4 exists.
		if(!array_key_exists($type,$this->Data['autoload']))
		$this->Data['autoload'][$type] = [];

		// add.
		$this->Data['autoload'][$type][$ns] = $dir;
		return $this;
	}

	public function AddAutoload0($ns,$dir) {
		return $this->AddAutoload('psr-0',$ns,$dir);
	}

	public function AddAutoload4($ns,$dir) {
		return $this->AddAutoload('psr-4',$ns,$dir);
	}

}
