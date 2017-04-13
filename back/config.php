<?php
	error_reporting(E_ALL);
	ini_set('display_errors','1');
	mysqli_report(MYSQLI_REPORT_ALL^MYSQLI_REPORT_INDEX);
	//mysqli_report(MYSQLI_REPORT_INDEX);
	require __DIR__.'/vendor/autoload.php';
	$username="*";
	$password="*";
	$database="*";
	$chavePrivada="*";
	$chavePublica="*";
	$gcm='A*';
	$auth=array('GCM'=>$gcm,// deprecated and optional, it's here only for compatibility reasons
	'VAPID'=>array('subject'=>'mailto:*',// can be a mailto: or your website address
	'publicKey'=>$chavePublica,// (recommended) uncompressed public key P-256 encoded in Base64-URL
	'privateKey'=>$chavePrivada,// (recommended) in fact the secret multiplier of the private key encoded in Base64-URL
	),);
	
	
	$db=new mysqli('localhost',$username,$password,$database);
	
	if($db->connect_errno>0){
		die('Unable to connect to database ['.$db->connect_error.']');
	}
	// $db->query('SET AUTOCOMMIT = 1');
	
	
	function buscaTodosUsuarios($db,$payload){
		if(!$result=$db->query("SELECT * FROM `Usuario`")){
			die('There was an error running the query ['.$db->error.']');
		}
		$retorno=array();
		while($row=$result->fetch_assoc()){
			$objeto=json_decode($row["api"],true);
			$temp=array("endpoint"=>$objeto["endpoint"],"payload"=>$payload . "|" . $row["nome"]
			,"userPublicKey"=>$objeto["keys"]["p256dh"],"userAuthToken"=>$objeto["keys"]["auth"]);
			array_push($retorno,$temp);
		}
		return $retorno;
	}
?>