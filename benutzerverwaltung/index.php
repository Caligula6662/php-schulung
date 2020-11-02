<!doctype html>

<html>
<head>
	<meta charset="utf-8">
	<title>Default</title>

	<link rel="stylesheet" href="css/main.css">
	<link rel="stylesheet" href="css/debug.css">
</head>

<body>

<!-- -------- PAGE HEADER -------- -->
<br>
<header class="fright loginheader">
	<form action="<?php echo $_SERVER['SCRIPT_NAME'] ?>" method="POST">
		<input type="hidden" name="formsentLogin">
		<fieldset>
			<legend>Login</legend>
			<span class='error'><?= $errorLogin ?></span><br>
			<input class="short" type="text" name="accountname" placeholder="Accountname">
			<input class="short" type="password" name="password" placeholder="Passwort">
			<input class="short" type="submit" value="Anmelden">
		</fieldset>
	</form>

	<p class="fright"><a href="registration.php">Sie haben noch keinen Account? Registrieren Sie sich einfach.</a></p>

</header>
<div class="clearer"></div>

<hr>
<!-- -------- PAGE HEADER END -------- -->
<h1>Default</h1>

<p>
	Hallo Besucher, bitte loggen Sie sich über obiges Formular ein, um die Inhalte für registrierte
	Benutzer sehen zu können.<br>
	<br>
	Auf der Folgeseite können Sie dann Ihre persönlichen Daten sowie Ihre
	Accountdaten verwalten, ein Avatarbild hochladen oder Ihr Passwort ändern.
</p>

<p>
	Sollten Sie sich noch nicht auf unserer Seite registriert haben, können Sie das über den
	Link unter dem Anmeldeformular nachholen. Oder klicken Sie einfach <a href="registration.php">hier</a>.
</p>

</body>
</html>