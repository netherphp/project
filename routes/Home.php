<?php

namespace Routes;

use Nether\Atlantis;
use Nether\Avenue;
use Nether\Common;

class Home
extends Atlantis\PublicWeb {

	protected string
	$DomainOfDesire = 'bob.majdak.net';

	public function
	OnReady(?Common\Datastore $ExtraData):
	void {

		$Domain = Common\Struct\Domain::FromDomain($_SERVER['HTTP_HOST'], 3);

		if($Domain->Get() !== $this->DomainOfDesire) {
			$this->Goto(new Atlantis\WebURL(
				$this->Request->GetPathForWeb(),
				$this->DomainOfDesire
			));

			return;
		}

		parent::OnReady($ExtraData);

		($this->Surface)
		->AddStyleURL('/themes/bob/css/styles.css');

		return;
	}

	////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////

	#[Atlantis\Meta\RouteHandler('/index')]
	public function
	Index():
	void {

		$Links = Atlantis\Struct\DropdownMenu::New('Links');
		$Links->ItemNew('Blog (pegasusgate.net)', 'mdi mdi-circle-outline', 'https://pegasusgate.net');
		$Links->ItemNew('Code (github.com)', 'si si-github', 'https://github.com/bobmagicii');
		$Links->ItemNew('Mastodon (phpc.social)', 'si si-mastodon', 'https://phpc.social/@bobmagicii');

		($this->App->Surface)
		->Area('home/index', [
			'Links' => $Links
		]);

		return;
	}

	#[Avenue\Meta\ErrorHandler(Avenue\Response::CodeForbidden)]
	#[Atlantis\Meta\TrafficReportSkip]
	public function
	ErrorForbidden():
	void {

		($this->App->Surface)
		->Area('error/forbidden');

		return;
	}

	#[Avenue\Meta\ErrorHandler(Avenue\Response::CodeNotFound)]
	#[Atlantis\Meta\TrafficReportSkip]
	public function
	ErrorNotFound():
	void {

		($this->App->Surface)
		->Area('error/not-found');

		return;
	}

}
