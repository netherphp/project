<?php

namespace Routes;

use \Exception;
use \Nether;

class Index extends Nether\Avenue\Route {

	public function Request() {
		// preprocess any inputs you want here. if you don't need to process
		// input or redirect or anything like that, you can delete this method.
	}

	public function Main() {
		echo "Hello World ^_^";
		return;
	}

}

