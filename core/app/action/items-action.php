<?php
if(isset($_GET["opt"]) && $_GET["opt"]=="add"){
if(count($_POST)>0){



	$user = new ItemData();

	$user->addExtraFieldString("lab_id", htmlentities($_POST["lab_id"]));
	$user->addExtraFieldString("name", htmlentities($_POST["name"]));
	$user->addExtraFieldString("minimum", htmlentities($_POST["minimum"]));
	$user->addExtraFieldString("maximum", htmlentities($_POST["maximum"]));
	$user->addExtraFieldString("unit", htmlentities($_POST["unit"]));

	$user->add();
	Core::alert("Parametro agregada!");
	Core::redir("./?view=items&opt=all");
}
}
if(isset($_GET["opt"]) && $_GET["opt"]=="add2"){
if(count($_POST)>0){



	$user = new ItemData();

	$user->addExtraFieldString("lab_id", htmlentities($_POST["lab_id"]));
	$user->addExtraFieldString("name", htmlentities($_POST["name"]));
	$user->addExtraFieldString("minimum", htmlentities($_POST["minimum"]));
	$user->addExtraFieldString("maximum", htmlentities($_POST["maximum"]));
	$user->addExtraFieldString("unit", htmlentities($_POST["unit"]));

	$user->add();
	Core::alert("Parametro agregada!");
	Core::redir("./?view=labs&opt=items&id=".$_POST["lab_id"]);
}
}
else if(isset($_GET["opt"]) && $_GET["opt"]=="update"){
if(count($_POST)>0){

	$user = ItemData::getById($_POST["_id"]);
	$user->addExtraFieldString("name", htmlentities($_POST["name"]));
	$user->addExtraFieldString("description", htmlentities($_POST["description"]));

	$user->update();

	Core::alert("Parametro actualizado!");
	Core::redir("./?view=items&opt=all");
}
}
else if(isset($_GET["opt"]) && $_GET["opt"]=="del"){
	$user = ItemData::getById($_GET["id"]);
	$user->del();
	Core::alert("Parametro eliminado!");
	Core::redir("./?view=items&opt=all");
}
else if(isset($_GET["opt"]) && $_GET["opt"]=="del2"){
	$user = ItemData::getById($_GET["id"]);
	$user->del();
	Core::alert("Parametro eliminado!");
	Core::redir("./?view=labs&opt=items&id=".$user->lab_id);
}




?>