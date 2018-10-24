<?php
	require_once("./cybersource.class.php");
	
	$secret = "575e33ad39824c84aa98b3051eb2a9793a898270ec694e42b03f6b17bc1bec6a1feb8b32f150473ea4e5ff80f63483c12b3e5639644e49a084e377e121968662536baaea1c98465a92e8744d0f29a61d8064866eb116404da199e6ba9ef81ad149d4999d5e6d4069984c21ecf9e7b4bc8a666982512848dc9109f5151260c7b5";
	$profile = "4861CC5A-5E57-4854-9EF0-B04755C37454";
	$access = "3ff35d09a9bd395182509a46553f4906";
	
	$cybersource = new Cybersource($profile, $access, $secret);
	print_r($cybersource->receipt());