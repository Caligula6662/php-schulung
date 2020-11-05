<?php

	#************ DB ************#
	define("DB_SYSTEM", "mysql"); // Treiber
	define("DB_HOST", "localhost"); // URL des Servers
	define("DB_NAME", "benutzerverwatlung"); // Tabelle auswählen - falls nur 1 vorhanden
	define("DB_USER", "root"); // Username
	define("DB_PWD", "");


	#************ Formulare ************#
	define("INPUT_MIN_LENGTH", 2);
	define("INPUT_MAX_LENGTH", 256);


	#************ ImageUpload ************#
	define("IMAGE_MAX_HEIGHT", 800);
	define("IMAGE_MAX_WIDTH", 800);
	define("IMAGE_MAX_SIZE", 128);
	define("IMAGE_ALLOWED_MIMETYPES", array( "image/jpeg", "image/jpg", "image/gif", "image/png" ));


	#************ Standard Pfade ************#
	define("IMAGE_UPLOAD_PATH", "uploads/userimages/");
	define("AVATAR_DUMMY_PATH", "css/images/avatar_dummy.png");


	#************ Debugging ************#
	define("DEBUG", true);
	define("DEBUG_F", true);
	define("DEBUG_DB", true);





?>