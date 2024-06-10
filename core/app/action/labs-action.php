<?php
if(isset($_GET["opt"]) && $_GET["opt"]=="add"){
if(count($_POST)>0){



	$user = new LabData();

	$user->addExtraFieldString("name", htmlentities($_POST["name"]));
	$user->addExtraFieldString("description", htmlentities($_POST["description"]));
	$user->addExtraFieldString("price", htmlentities($_POST["price"]));

	$user->add();
	Core::alert("Prueba de laboratorio agregada!");
	Core::redir("./?view=labs&opt=all");
}
}
else if(isset($_GET["opt"]) && $_GET["opt"]=="update"){
if(count($_POST)>0){

	$user = LabData::getById($_POST["_id"]);
	$user->addExtraFieldString("name", htmlentities($_POST["name"]));
	$user->addExtraFieldString("description", htmlentities($_POST["description"]));
	$user->addExtraFieldString("price", htmlentities($_POST["price"]));

	$user->update();

	Core::alert("Prueba de laboratorio actualizado!");
	Core::redir("./?view=labs&opt=all");
}
}
else if(isset($_GET["opt"]) && $_GET["opt"]=="del"){
	$user = LabData::getById($_GET["id"]);
	$user->del();
	Core::alert("Prueba de laboratorio eliminado!");
	Core::redir("./?view=labs&opt=all");
}



?>