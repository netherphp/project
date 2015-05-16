<?php

namespace Nether\Project;
use \Nether;

class Package {

	protected $RealBooter;
	public function GetRealBooter() { return $this->RealBooter; }
	public function SetRealBooter(Nether\Project\RealBooter $rb) { $this->RealBooter = $rb; return $this; }

	protected $Name;
	public function GetName() { return $this->Name; }
	public function SetName($n) { $this->Name = $n; return $this; }

	protected $Version;
	public function GetVersion() { return $this->Version; }
	public function SetVersion($v) { $this->Version = $v; return $this; }

	protected $Info;
	public function GetInfo() { return $this->Info; }
	public function SetInfo($i) { $this->Info = $i; return $this; }

	protected $Enabled = false;
	public function IsEnabled() { return $this->Enabled; }
	public function SetEnabled($b) { $this->Enabled = (bool)$b; return $this; }

	////////////////////////////////
	////////////////////////////////

	public function Ask(Nether\Project\RealBooter $realboot) {

		$realboot
		->ShowBanner($this->Name)
		->ShowMessage($this->Info)
		->ShowPrompt(
			"Setup {$this->Name}?",'y',
			function($yn){
				if(strtolower($yn) === 'y') $this->SetEnabled(true);
				else $this->SetEnabled(false);
				return;
			}
		);

		return $this;
	}


	////////////////////////////////
	////////////////////////////////

	public function Setup(Nether\Project\RealBooter $realboot) {

		return $this;
	}

	public function Install(Nether\Project\RealBooter $realboot) {

		return $this;
	}

	public function Finish(Nether\Project\RealBooter $realboot) {

		return $this;
	}

}

