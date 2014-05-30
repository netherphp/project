<?php

namespace Routes\Error;

use \Exception;
use \Nether;

class NotFound extends Nether\Avenue\Route {

	public function Main() {
		echo "Error 404 - Not Found. Doh.";
		return;
	}

}
