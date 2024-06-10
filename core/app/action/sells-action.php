<?php
if(isset($_GET["opt"]) && $_GET["opt"]=="add"){
if(count($_POST)>0){

    $lab = LabData::getById($_POST["lab_id"]);

	$sell = new SellData();

	$sell->addExtraFieldString("person_id", htmlentities($_POST["person_id"]));
	$sell->addExtraFieldString("amount", htmlentities($lab->price));

	$se=$sell->add();

	$user = new ExamData();

	$user->addExtraFieldString("lab_id", htmlentities($_POST["lab_id"]));
	$user->addExtraFieldString("person_id", htmlentities($_POST["person_id"]));
    $user->addExtraFieldString("sell_id",$se[1]);
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

	Core::alert("Venta agregada!");
	Core::redir("./?view=sells&opt=open&id=".$se[1]);
}
}
else if(isset($_GET["opt"]) && $_GET["opt"]=="update"){
if(count($_POST)>0){

	$user = ExamData::getById($_POST["_id"]);
	$user->addExtraFieldString("lab_id", htmlentities($_POST["lab_id"]));
	$user->addExtraFieldString("person_id", htmlentities($_POST["person_id"]));

	$user->update();

	Core::alert("Examen de laboratorio actualizado!");
	Core::redir("./?view=sells&opt=all");
}
}
else if(isset($_GET["opt"]) && $_GET["opt"]=="del"){
	$user = SellData::getById($_GET["id"]);
	$user->del();
	Core::alert("Venta eliminado!");
	Core::redir("./?view=sells&opt=all");
}
else if(isset($_GET["opt"]) && $_GET["opt"]=="addpayment"){


$pay = new PaymentData();
	$pay->addExtraFieldString("sell_id", htmlentities($_POST["sell_id"]));
	$pay->addExtraFieldString("amount", htmlentities($_POST["amount"]));
$pay->add();


////////////////////////
$exams = ExamData::getAllBy("sell_id",$_POST['sell_id']);
$payments = PaymentData::getAllBy("sell_id",$_POST['sell_id']);
$total_paid =0;
foreach($payments as $pay){ $total_paid+=$pay->amount;}
$total=0;
    foreach($exams as $con){
$l = LabData::getByID($con->lab_id);
$total+=$l->price;
}
//////////////////////

if($total_paid>=$total){
$sell = SellData::getById($_POST["sell_id"]);
	$sell->addExtraFieldString("payment_status", 1);
$sell->update();

}

	Core::redir("./?view=sells&opt=open&id=".$_POST['sell_id']);

}

?>