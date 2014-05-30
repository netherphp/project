<?php

require(sprintf(
	'%s/conf/start.php',
	%PORTABLE_PROJECT_ROOT%
));

////////////////
////////////////

$avenue = (new Nether\Avenue)
->SetCommonspace('Routes')
->SetErrorRoute(404,'Routes\\Error\\NotFound')
->Run();
