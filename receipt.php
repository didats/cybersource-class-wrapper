<?php
	/*
		Cybersource receipt
		==
		It took few days trying and testing the cybersource payment, finally paid off.
		You are eligible to do anything with this code.
		
		Author:
		Didats Triadi <didats@gmail.com>
		rimbunesia.com
		
		October 24th, 2018
	*/
	require_once("./cybersource.class.php");
	
	$secret = "<secret>";
	$profile = "<profile>";
	$access = "<access>";
	
	$cybersource = new Cybersource($profile, $access, $secret);
	print_r($cybersource->receipt());
