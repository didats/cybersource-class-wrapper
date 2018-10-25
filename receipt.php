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
	
	$secret = "406d36a852e44fff815f643de1bb44bc86c3a8429d554a1e9f730db08529001e9f36e4cad9784883b643afda9dede3517dc2bf5e4ced4282a9f4220e0c3150adcfd1dcb55dfe423fae9635b62d31168e41e4b5efdf91485ab3c78e8897703e1b34c030e2422547efbfeb5e0df0fce8a9d0d5b6f2d67a4a2cba213eb4de7946ac";
	$profile = "2778AD28-A080-4625-8054-3BE4303DC62D";
	$access = "ae6cdfb2378535de85790ce77cec76d6";
	
	$cybersource = new Cybersource($profile, $access, $secret);
	print_r($cybersource->receipt());