<?php

//% REQUIRE-CONF-START

$avenue = (new Nether\Avenue)
->SetCommonspace('Routes')
->SetErrorRoute(404,'Routes\\Error\\NotFound')
->Run();
