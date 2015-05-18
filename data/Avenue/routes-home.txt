<?php

namespace Routes;
use \Nether;
use \Routes;

class Home {

	public function Index() {
		echo "Hello World!";
		return;
	}

	public function About() {
		echo "About Page!";
		return;
	}

	public function NotFound() {
		header("404 Not Found");
		echo "404 - Not Found";
		return;
	}

}
