<?php
	/*
		Cybersource class
		==
		It took few days trying and testing the cybersource payment, finally paid off.
		You are eligible to do anything with this code.
		
		Author:
		Didats Triadi <didats@gmail.com>
		rimbunesia.com
		
		October 24th, 2018
	*/
	class Cybersource {
		private $accessKey;
		private $profileID;
		private $secretKey;
		
		private $signVariables = "access_key,profile_id,transaction_uuid,signed_field_names,unsigned_field_names,signed_date_time,locale,transaction_type,reference_number,amount,currency";
		
		private $isLive = false;
		
		// bill_address1, bill_city, bill_country, customer_email, customer_lastname
		var $userAddress;
		var $userCity;
		var $userCountry;
		var $userEmail;
		var $userFirstName;
		var $userLastName;
		
		private $reasonCode = array(
			0 => "Invalid data sent to cybersource or not complete",
			100 => "Successful transaction",
			102 => "Invalid transaction, one or more fields contains invalid data",
			104 => "Duplicate transaction",
			110 => "Only a partial amount was approved",
			150 => "General system failure",
			151 => "Server timeout occured",
			152 => "Service timeout occured",
			200 => "Authorization approved but declined by Cybersource",
			201 => "Issuing bank has question about the request",
			202 => "Expired card",
			203 => "Card declined",
			204 => "Insufficient funds in the account",
			205 => "Stolen or lost card",
			207 => "Issuing bank unavailable",
			208 => "Inactive card or card no authorized",
			210 => "The card has reached the limit",
			211 => "Invalid CVN",
			221 => "Please contact the payment processor",
			222 => "Account frozen",
			230 => "Authorization approved but declined by Cybersource",
			231 => "Invalid account number",
			232 => "Card not accepted",
			233 => "General decline",
			234 => "There is problem with your Cybersource account",
			236 => "Processor failure",
			240 => "Card invalid",
			475 => "Card holder is not authenticate",
			476 => "Payer authentication could not be authenticated",
			481 => "Transaction declined",
			520 => "Authorization approved but declined by Cybersource"
		);
		
		/*
			The class required you to enter profileID, accessKey and secretKey
			those variables collected from Cybersource Business Center
		*/
		function __construct($profileID = "", $accessKey = "", $secretKey = "") {
			if (empty($profileID) || empty($accessKey) || empty($secretKey)) {
				echo "[ERROR] ProfileID, accessKey and secretKey is REQUIRED";
				exit;
			}
			else {
				$this->accessKey = $accessKey;
				$this->profileID = $profileID;
				$this->secretKey = $secretKey;
			}
		}
		
		private function sign($params) {
			$fields = explode(",", $this->signVariables);
			$signData = [];
			foreach ($fields as $field) {
			   $signData[] = $field . "=" . $params[$field];
			}
			$result = base64_encode(hash_hmac('sha256', implode(",", $signData), $this->secretKey, true));
			
			return $result;
		}
		
		/*
			Do Payment
			It is required to send the:
			refNumber = Your version of referenceNumber from your system (String)
			amount = Amount in Float
			currency = 3 digit currency
			
			These variable are optional, but you could send the data as well
			transactionID = generated randomly from the script
			locale = en
			
			
			This method will result a generated form
		*/
		function pay($refNumber, $amount, $currency, $transactionID = "", $locale = "en") {
			
			if (empty($refNumber) || empty($amount) || empty($currency)) {
				echo "[ERROR] refNumber, amount and currency is REQUIRED";
				exit;
			}
			else if(empty($this->userAddress)) {
				echo "[ERROR] Please set userAddress";
				exit;
			}
			else if(empty($this->userCity)) {
				echo "[ERROR] Please set userCity";
				exit;
			}
			else if(empty($this->userEmail)) {
				echo "[ERROR] Please set userEmail";
				exit;
			}
			else if(empty($this->userFirstName)) {
				echo "[ERROR] Please set userFirstName";
				exit;
			}
			else if(empty($this->userLastName)) {
				echo "[ERROR] Please set userLastName";
				exit;
			}
			
			if (empty($transactionID)) {
				$transactionID = uniqid();
			}
			
			$url = "https://testsecureacceptance.cybersource.com/pay";
			if($this->isLive) {
				$url = "https://secureacceptance.cybersource.com/pay";
			}
			
			$arr = array(
				'access_key' => $this->accessKey,
				'profile_id' => $this->profileID,
				'locale' => $locale,
				'transaction_uuid' => $transactionID,
				'signed_field_names' => $this->signVariables,
				'unsigned_field_names' => "",
				'signed_date_time' => gmdate("Y-m-d\TH:i:s\Z"),
				'transaction_type' => "authorization",
				'reference_number' => $refNumber,
				'amount' => $amount,
				'currency' => strtoupper($currency),
				'bill_city' => $this->userCity,
				'bill_country' => $this->userCountry,
				'customer_email' => $this->userEmail,
				'bill_address1' => $this->userAddress,
				'customer_firstname' => $this->userFirstName,
				'customer_lastname' => $this->userLastName
			);
			// bill_address1, bill_city, bill_country, customer_email, customer_lastname
			
			$signature = $this->sign($arr);
			
			$html = "<html><head></head><body><form action='$url' method='post'/>"; 
			foreach($arr as $key => $value) {
				$html .= "<input type='hidden' name='$key' value='$value' />";
			}
			
			$html .= "<input type='hidden' name='signature' value='$signature' />";
			
			$html .= "</form>";
			$html .= "<script type='text/javascript'>";
			$html .= "document.forms[0].submit();";
			$html .= "</script>";
			$html .= "</body>";
			echo $html;
		}
		
		function receipt() {
			global $_REQUEST;
			
			$paymentMethod = $_REQUEST['req_payment_method'];
			$amount = $_REQUEST['auth_amount'];
			$cybersourceTransactionID = $_REQUEST['transaction_id'];
			$currency = $_REQUEST['req_currency'];
			$status = $_REQUEST['decision'];
			$message = $_REQUEST['message'];
			$ref = $_REQUEST['req_reference_number'];
			$transactionID = $_REQUEST['req_transaction_uuid'];
			$code = (int)$_REQUEST['decision_reason_code'];
			$codeMessage = $this->reasonCode[$code];
			
			return array(
				'method' => $paymentMethod,
				'amount' => $amount,
				'currency' => $currency,
				'ref' => $ref,
				'transactionID' => $transactionID,
				'code' => $code,
				'message' => $message,
				'reason' => $codeMessage,
				'cybersource_transaction' => $cybersourceTransactionID
			);
		}
	}
	
	
	