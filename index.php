<?php
header('Strict-Transport-Security: max-age=31536000');
?>


<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>Push Codelab</title>

  <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
  <link rel="stylesheet" href="https://code.getmdl.io/1.2.1/material.indigo-pink.min.css">
  <script defer src="https://code.getmdl.io/1.2.1/material.min.js"></script>
  <link rel="stylesheet" href="styles/index.css">
</head>

<body>

  <header>
    <h1>Bora comer</h1>
  </header>

  <main>
    <p>
      <button disabled class="js-push-btn mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect">
        Enable Push Messaging
      </button>
    </p>

	<form form action="back/newSub.php" method="post">
	  Api:<br>
	  <input type="text" id="jsonApi" name="Json"><br>
	  Seu Nominho:<br>
	  <input type="text" name="name">
	  <input type="submit" value="Submit">
	</form>
    <!--<textarea class="js-subscription-json"></textarea>-->
    </section>
  </main>
  <script src="scripts/main.js?nocache"></script>

  <script src="https://code.getmdl.io/1.2.1/material.min.js"></script>
</body>
</html>
