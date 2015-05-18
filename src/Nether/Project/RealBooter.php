<?php

namespace Nether\Project;
use \Nether;
use \Exception;

class RealBooter {

	public $Packages = [];
	/*//
	@type array
	a list of all the packages we will attempt to install.
	//*/

	public $InstallerRoot;

	////////////////////////////////
	////////////////////////////////

	public function __construct() {

		// take note of our package directory.
		$this->InstallerRoot = dirname(dirname(dirname(dirname(__FILE__))));

		return;
	}

	public function Finish() {

		$this->ShowBanner("Realbooting Complete");

		foreach($this->Packages as $pkg)
		$pkg->Finish($this);

		return;
	}

	////////////////////////////////
	////////////////////////////////

	protected $ProjectRoot;
	/*//
	@type string
	the root path to the project.
	//*/

	public function GetProjectRoot() { return $this->ProjectRoot; }
	public function SetProjectRoot($r) { $this->ProjectRoot = $r; return $this; }

	////////////////////////////////
	////////////////////////////////

	public function GetComposer() {

		$filepath = "{$this->ProjectRoot}/composer.json";

		try { $composer = new Nether\Project\Composer($filepath); }
		catch(Exception $e) {
			$this->ShowMessage($e->getMessage());
			exit(0);
		}

		return $composer;
	}

	////////////////////////////////
	////////////////////////////////

	public function AddPackage(Nether\Project\Package $pkg) {
		$this->Packages[$pkg->GetName()] = $pkg;
		$pkg->SetRealBooter($this);
		return $this;
	}

	public function GetPackage($name) {
		if(array_key_exists($name,$this->Packages))
		return $this->Packages[$name];

		return false;
	}

	////////////////////////////////
	////////////////////////////////

	public function PromptProjectRoot() {

		$this->ShowMessage(
		'Choose the directory to you wish to realboot this application in. By '.
		'default the current directory is chosen, hit enter to accept.'
		);

		$this->ShowPrompt(
			'Project Root:',
			getcwd(),
			[$this,'AcceptProjectRoot']
		);

		return $this;
	}

	public function AcceptProjectRoot($path) {

		if(is_file($path))
		throw new Exception('ERROR: specified path is currently a file.');

		if(!is_dir($path)) {
			$this->ShowPrompt(
				'Directory does not exist. Create?','y',
				function($yn) use($path){
					if(strtolower($yn) === 'y') @mkdir($path,0777,true);
					else exit(0);
				}
			);
		}

		if(!is_dir($path))
		throw new Exception('ERROR: unable to create directory.');

		$this->ProjectRoot = $path;
		return;
	}

	public function PromptComposer() {
		$this->GetComposer();
		return $this;
	}

	public function PromptPackages() {

		foreach($this->Packages as $pkg) {
			if($pkg instanceof Nether\Project\Package\Core)
			continue;

			$pkg->Ask($this);

			if(!$pkg->IsEnabled()) {
				unset($this->Packages[$pkg->GetName()]);
				continue;
			}
		}

		return $this;
	}

	public function PromptConfirm() {

		$this
		->ShowBanner('Confirm Packages')
		->ShowMessage('The following packages are going to be configured:');

		foreach($this->Packages as $pkg) {
			echo "\t- {$pkg->GetName()} {$pkg->GetVersion()}", PHP_EOL;
		}
		echo PHP_EOL;

		$this->ShowPrompt(
			'Finish Realbooting?','y',
			function($yn) {
				if(strtolower($yn) === 'n') {
					$this->ShowMessage('Realbooting canceled.');
					exit(0);
				}
			}
		);

		return $this;
	}

	////////////////////////////////
	////////////////////////////////

	public function SetupPackages() {

		$halted = false;

		foreach($this->Packages as $pkg) {
			try { $pkg->Setup($this); }
			catch(Exception $e) {
				$this->ShowMessage($e->getMessage());
				$halted = true;
			}
		}

		if($halted) $this->ShowMessage('Operation aborted.');
		else $this->ShowMessage('Operation complete.');

		return $this;
	}

	////////////////////////////////
	////////////////////////////////

	public function ShowBanner($msg) {
	/*//
	print a header banner to the console with a message inside it.
	//*/

		$linefill = (75 - (strlen($msg) + 4));
		printf('%s%s%s',PHP_EOL,str_repeat('=',75),PHP_EOL);
		printf('== %s %s%s%s',$msg,str_repeat('=',$linefill),PHP_EOL,PHP_EOL);
		return $this;
	}

	public function ShowMessage($msg) {
	/*//
	print a generic message to the console.
	//*/

		echo wordwrap($msg).PHP_EOL.PHP_EOL;
		return $this;
	}

	public function ShowPrompt($label,$value,callable $callback) {
	/*//
	print a prompt and wait for user input.
	//*/

		printf(
			'%s [%s]$ ',
			$label,
			$value
		);

		$input = trim(fgets(STDIN));
		if(!$input) $input = $value;

		try { call_user_func_array($callback,[$input]); }
		catch(Exception $e) {
			$this->ShowMessage($e->getMessage());
			$this->ShowPrompt($label,$value,$callback);
		}

		return $this;
	}

	////////////////////////////////
	////////////////////////////////

	public function CreateProjectDirectory($dir) {
		$filepath = "{$this->ProjectRoot}/{$dir}";

		if(!file_exists($filepath)) @mkdir($filepath,0777,true);
		if(!file_exists($filepath)) throw new Exception("unable to create {$dir}");

		return $this;
	}

	public function InstallProjectFile($src,$dest) {
		$srcpath = "{$this->InstallerRoot}/data/{$src}";
		$destpath = "{$this->ProjectRoot}/{$dest}";

		echo ">> Installing {$dest}", PHP_EOL;
		copy($srcpath,$destpath);

		return $this;
	}

}
