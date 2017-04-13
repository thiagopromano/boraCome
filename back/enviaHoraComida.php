<?php
	require 'config.php';
	
	use Minishlink\WebPush\WebPush;
		$webPush = new WebPush($auth);
	
	
	// $notifications = buscaTodosUsuarios($db, "horaComer");
	
	
	if(!$result=$db->query("SELECT * FROM `Usuario`")){
		die('There was an error running the query ['.$db->error.']');
	}
	
	$payload = "horaComer";
	$retorno=array();
	while($row=$result->fetch_assoc()){
		$check = "";
		
		$payload.="|".$row["foicome"]."|".$row["nome"];
		$objeto=json_decode($row["api"],true);
		$temp=array("nome"=>$row["nome"],"endpoint"=>$objeto["endpoint"]
		,"userPublicKey"=>$objeto["keys"]["p256dh"],"userAuthToken"=>$objeto["keys"]["auth"]);
		array_push($retorno,$temp);
	}
	
	
	
	// send multiple notifications with payload
	foreach ($retorno as $notification) {
	    $webPush->sendNotification(
	        $notification['endpoint'],
	        $payload.'|'.$notification['nome'], // optional (defaults null)
	        $notification['userPublicKey'], // optional (defaults null)
	        $notification['userAuthToken'] // optional (defaults null)
	    );
	}
	
	//var_dump("ahhh\n\n\n");
	var_dump($webPush->flush());
	
?>