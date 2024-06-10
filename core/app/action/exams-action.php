<?php
if(isset($_GET["opt"]) && $_GET["opt"]=="add"){
if(count($_POST)>0){



	$user = new ExamData();

	$user->addExtraFieldString("lab_id", htmlentities($_POST["lab_id"]));
	$user->addExtraFieldString("person_id", htmlentities($_POST["person_id"]));

	$items = ItemData::getAllBy("lab_id",$_POST['lab_id']);
	$ex=$user->add();
	foreach($items as $i){

		$r = new ResultData();
	    $r->addExtraFieldString("lab_id", htmlentities($_POST["lab_id"]));
	    $r->addExtraFieldString("item_id", htmlentities($i->id));
	    $r->addExtraFieldString("val", htmlentities(0));
	    $r->addExtraFieldString("exam_id", htmlentities($ex[1]));

		$r->add();

	}

	Core::alert("Examen de laboratorio agregado!");
	Core::redir("./?view=exams&opt=all");
}
}
else if(isset($_GET["opt"]) && $_GET["opt"]=="add2"){
if(count($_POST)>0){



	$user = new ExamData();

	$user->addExtraFieldString("sell_id", htmlentities($_POST["sell_id"]));
	$user->addExtraFieldString("lab_id", htmlentities($_POST["lab_id"]));
	$user->addExtraFieldString("person_id", htmlentities($_POST["person_id"]));

	$items = ItemData::getAllBy("lab_id",$_POST['lab_id']);
	$ex=$user->add();
	foreach($items as $i){

		$r = new ResultData();
	    $r->addExtraFieldString("lab_id", htmlentities($_POST["lab_id"]));
	    $r->addExtraFieldString("item_id", htmlentities($i->id));
	    $r->addExtraFieldString("val", htmlentities(0));
	    $r->addExtraFieldString("exam_id", htmlentities($ex[1]));

		$r->add();

	}

	Core::alert("Examen de laboratorio agregado!");
	Core::redir("./?view=sells&opt=open&id=".$_POST['sell_id']);
}
}
else if(isset($_GET["opt"]) && $_GET["opt"]=="update"){
if(count($_POST)>0){

	$user = ExamData::getById($_POST["_id"]);
	$user->addExtraFieldString("lab_id", htmlentities($_POST["lab_id"]));
	$user->addExtraFieldString("person_id", htmlentities($_POST["person_id"]));

	$user->update();

	Core::alert("Examen de laboratorio actualizado!");
	Core::redir("./?view=exams&opt=all");
}
}
else if(isset($_GET["opt"]) && $_GET["opt"]=="finalize"){


	$user = ExamData::getById($_GET["id"]);
	$user->addExtraFieldString("status", 1);

	$user->update();

	Core::alert("Examen de laboratorio actualizado!");
	Core::redir("./?view=exams&opt=all");

}
else if(isset($_GET["opt"]) && $_GET["opt"]=="del"){
	$user = ExamData::getById($_GET["id"]);
	$user->del();
	Core::alert("Examen de laboratorio eliminado!");
	Core::redir("./?view=exams&opt=all");
}
else if(isset($_GET["opt"]) && $_GET["opt"]=="del2"){
	$user = ExamData::getById($_GET["id"]);
	$user->del();
	Core::alert("Examen de laboratorio eliminado!");
	Core::redir("./?view=sells&opt=open&id=".$user->sell_id);
}
else if(isset($_GET["opt"]) && $_GET["opt"]=="saveresults"){
$exam = ExamData::getById($_POST["_id"]);
$pacient = PersonData::getById($exam->person_id);
$items = ItemData::getAllBy("lab_id",$exam->lab_id);

foreach($items as $it){
    $ie = ResultData::getByIE( $it->id, $exam->id);

    $ie->val = $_POST["item_".$it->id];
    $ie->update();
}

	Core::alert("Datos del Examen Actualizados!");
	Core::redir("./?view=exams&opt=all");


}

?>