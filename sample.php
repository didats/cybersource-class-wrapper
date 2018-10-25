<?php
/*
	Cybersource sample
	==
	It took few days trying and testing the cybersource payment, finally paid off.
	You are eligible to do anything with this code.
	
	Author:
	Didats Triadi <didats@gmail.com>
	rimbunesia.com
	
	October 24th, 2018
*/
	require_once("./cybersource.class.php");
	
	$secret = "<secret-key>";
	$profile = "<profile-id>";
	$access = "<access-key>";
	
	// $refNumber, $amount, $currency, $transactionID = uniqid()
	$ref = time() . "_" . substr(md5(mt_rand(0, mt_getrandmax())), 8, 8);
	
	$cybersource = new Cybersource($profile, $access, $secret);
	$cybersource->userAddress = "Sawojajar";
	$cybersource->userCity = "Malang";
	$cybersource->userCountry = "ID";
	$cybersource->userEmail = "didats@gmail.com";
	$cybersource->userFirstName = "Didats";
	$cybersource->userLastName = "Triadi";
	$cybersource->mdd1 = "MDD1"; // Channel Operation
	$cybersource->mdd2 = "MDD2"; // Merchant Name
	$cybersource->mdd3 = "MDD3"; // Category
	$cybersource->mdd4 = "MDD4"; // Product Name
	$cybersource->pay($ref, 32, "KWD");
