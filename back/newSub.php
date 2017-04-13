<?php

	require 'config.php';

	use Minishlink\WebPush\WebPush;

	
	$jsonRecebido = $_POST["Json"];
	$nomeRecebido = $_POST["name"];
	$objeto = json_decode($jsonRecebido, true);
	
	

	if (!$statement = $db->prepare ("REPLACE INTO Usuario (api, foicome, nome) values( ?,?,?);"))
	{
		 echo "Prepare failed: (" . $db->errno . ") " . $db->error . $statement;
	}
	$comeee = 0;
	$statement->bind_param('sis', $jsonRecebido, $comeee, $nomeRecebido);
	if(!$result = $statement->execute()){
    	die('There was an error running the query [' . $db->error . ']');
	}
	// $db.commit();
	// $statement->close();
	
	$webPush = new WebPush($auth);
	
	
	$notifications = buscaTodosUsuarios($db, "novoUsuario|".$nomeRecebido);
	
	// send multiple notifications with payload
	foreach ($notifications as $notification) {
	    $webPush->sendNotification(
	        $notification['endpoint'],
	        $notification['payload'], // optional (defaults null)
	        $notification['userPublicKey'], // optional (defaults null)
	        $notification['userAuthToken'] // optional (defaults null)
	    );
	}
	
	//var_dump("ahhh\n\n\n");
	var_dump($webPush->flush());
	
	
	require 'fim.php';
?>
