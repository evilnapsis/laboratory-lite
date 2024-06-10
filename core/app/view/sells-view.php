<?php 
// si el usuario no esta logeado
if(!isset($_SESSION["user_id"])){ Core::redir("./");}
$user= UserData::getById($_SESSION["user_id"]);
// si el id  del usuario no existe.
if($user==null){ Core::redir("./");}
?>
<?php if(isset($_GET["opt"]) && $_GET['opt']=="all"):
$contacts = SellData::getAll();
  ?>










            <div class="row">
            <div class="col-md-12">
              <div class="card mb-4">
                <div class="card-header">Ventas</div>
                <div class="card-body">
<a href="./?view=sells&opt=new" class="btn btn-info">Nueva Venta</a>
                  <!-- /.row--><br><br>
                  <div class="table-responsive">

<?php if(count($contacts)>0):?>
                    <table class="table border mb-0">
                      <thead class="table-light fw-semibold">
                        <tr class="align-middle">

                          <th>#</th>
                          <th class="">Paciente</th>
                          <th class="">Prueba(s)</th>
                          <th class="">$ Monto</th>
                          <th class="">Estado</th>
                          <th class="">Fecha</th>

                          
                          <th></th>
                        </tr>
                      </thead>
                      <tbody>

    <?php foreach($contacts as $con):
        $amount = 0;
        $tests = array();
        $exams = ExamData::getAllBy("sell_id",$con->id);
        foreach($exams as $ex){ $l = LabData::getById($ex->lab_id); $amount+=$l->price; $tests[]=$l->name;}
        ?>
      <tr>
        <td><a href="./?view=sells&opt=open&id=<?php echo $con->id; ?>" class="btn btn-link btn-sm">#<?php echo $con->id; ?></a></td>
        <td><?php $p = PersonData::getByID($con->person_id); echo $p->name." ".$p->lastname; ?></td>
        <td><?php echo implode(",",$tests); ?></td>
        <td>$ <?php echo number_format($amount,2,".",","); ?></td>
        
        <td><?php if($con->payment_status==0):?>
          <span class="badge text-bg-warning">Pendiente</span>
          <?php else:?>
            <span class="badge text-bg-success">Finalizado</span>
            <?php endif; ?>  
</td>
        <td><?php echo $con->created_at; ?></td>

        <td>
          <a href="./?view=sells&opt=open&id=<?php echo $con->id; ?>" class="btn btn-warning btn-sm"><i class="bi-pencil"></i></a>
          <a href="./?action=sells&opt=del&id=<?php echo $con->id; ?>" class="btn btn-danger btn-sm"><i class="bi-trash"></i></a>
        </td>
      </tr>
    <?php endforeach; ?>
                      </tbody>
                    </table>
<?php else:?>
  <p class="alert alert-warning">No hay Ventas</p>
<?php endif; ?>
                  </div>
                </div>
              </div>
            </div>
            <!-- /.col-->
          </div>













<?php elseif(isset($_GET["opt"]) && $_GET["opt"]=="new"):?>
<div class="">
<div class="row">
<div class="col-md-12">

              <div class="card mb-4">
                <div class="card-header">Ventas </div>
                <div class="card-body">
<h2>Nueva Venta</h2>

                <div class="row">
                  <div class="col-md-6">
<form method="post" action="./?action=sells&opt=add">
  <div class="form-group">
    <label for="exampleInputEmail1">Paciente</label>
    <select name="person_id" required class="form-control">
      <option value="">-- SELECCIONE --</option>
      <?php foreach(PersonData::getAll() as $lab):?>
        <option value="<?php echo $lab->id;?>"><?php echo $lab->name." ".$lab->lastname;?></option>
      <?php endforeach; ?>
    </select>

  </div>

  <div class="form-group">
    <label for="exampleInputEmail1">Tipo de Prueba</label>
    <select name="lab_id" required class="form-control">
      <option value="">-- SELECCIONE --</option>
      <?php foreach(LabData::getAll() as $lab):?>
        <option value="<?php echo $lab->id;?>"><?php echo $lab->name . " $ ".$lab->price;?></option>
      <?php endforeach; ?>
    </select>

  </div>
<br>
  <div class="d-grid gap-2">
  <button type="submit" class="btn btn-primary ">Crear Venta</button>
</div>
</form>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
<?php elseif(isset($_GET["opt"]) && $_GET["opt"]=="edit"):
$contact = ExamData::getById($_GET["id"]);
  ?>
  <div class="">
<div class="row">
<div class="col-md-12">

              <div class="card mb-4">
                <div class="card-header">Pruebas de Laboratorio</div>
                <div class="card-body">
<h2>Editar Prueba</h2>
<div class="row">
  <div class="col-md-6">
<form method="post" action="./?action=sells&opt=update">
  <input type="hidden" name="_id" value="<?php echo $contact->id; ?>">
  <div class="form-group">
    <label for="exampleInputEmail1">Nombre</label>
    <input type="text" required name="name" value="<?php echo $contact->name; ?>" class="form-control" id="exampleInputEmail1" placeholder="Nombre">
  </div>
  <div class="form-group">
    <label for="exampleInputEmail1">Unidad</label>
    <input type="text" required name="unit" value="<?php echo $contact->unit; ?>" class="form-control" id="exampleInputEmail1" placeholder="Unidad">
  </div>
    <div class="form-group">
    <label for="exampleInputEmail1">Minimo</label>
    <input type="text" required name="minimum" value="<?php echo $contact->minimum; ?>" class="form-control" id="exampleInputEmail1" placeholder="Minimo">
  </div>

  <div class="form-group">
    <label for="exampleInputEmail1">Maximo</label>
    <input type="text" required name="maximum" value="<?php echo $contact->maximum; ?>" class="form-control" id="exampleInputEmail1" placeholder="Maximo">
  </div>

  <div class="d-grid gap-2">
  <button type="submit" class="btn btn-success ">Actualizar</button>
</div>
</form>

</div>
</div>

</div>
</div>

</div>
</div>
</div>
<?php elseif(isset($_GET["opt"]) && $_GET["opt"]=="capture"):
$exam = ExamData::getById($_GET["id"]);
$pacient = PersonData::getById($exam->person_id);
$items = ItemData::getAllBy("lab_id",$exam->lab_id);
  ?>
  <div class="">
<div class="row">
<div class="col-md-12">

              <div class="card mb-4">
                <div class="card-header">Pruebas de Laboratorio</div>
                <div class="card-body">
<h2>Capturar Resultados del Examen</h2>
<div class="row">
  <div class="col-md-6">
<form method="post" action="./?action=sells&opt=saveresults">
  <input type="hidden" name="_id" value="<?php echo $exam->id; ?>">
  <div class="form-group">
    <label for="exampleInputEmail1">Paciente</label>
    <input type="text" required name="name" value="<?php echo $pacient->name." ".$pacient->lastname; ?> " readonly class="form-control" id="exampleInputEmail1" placeholder="Nombre">
  </div>
  <?php foreach($items as $it):?>
    <?php $ie = ResultData::getByIE( $it->id, $exam->id);
//print_r($ie);
    ?>
  <div class="form-group">
    <label for="exampleInputEmail1"><?php echo $it->name; ?> (<?php echo $it->unit; ?>)</label>
    <input type="text" required name="item_<?php echo $it->id; ?>" value="<?php echo $ie->val; ?>" class="form-control" id="exampleInputEmail1" placeholder="<?php echo $it->name; ?> (<?php echo $it->unit; ?>)">
  </div>
<?php endforeach; ?>

<br>
  <div class="d-grid gap-2">
  <button type="submit" class="btn btn-success ">Actualizar</button>
</div>
</form>

</div>
</div>

</div>
</div>

</div>
</div>
</div>
<?php elseif(isset($_GET["opt"]) && $_GET["opt"]=="viewresults"):
$exam = ExamData::getById($_GET["id"]);
$pacient = PersonData::getById($exam->person_id);
$items = ItemData::getAllBy("lab_id",$exam->lab_id);
  ?>
  <div class="">
<div class="row">
<div class="col-md-12">

              <div class="card mb-4">
                <div class="card-header">Pruebas de Laboratorio</div>
                <div class="card-body">
<h2>Ver Resultados del Examen</h2>
<div class="row">
  <div class="col-md-6">
<form>
  <input type="hidden" name="_id" value="<?php echo $exam->id; ?>">
  <div class="form-group">
    <label for="exampleInputEmail1">Paciente</label>
    <input type="text" required name="name" value="<?php echo $pacient->name." ".$pacient->lastname; ?> " readonly class="form-control" id="exampleInputEmail1" placeholder="Nombre">
  </div>

<br>
<table class="table table-bordered">
  
<thead>
  <th>Parametro</th>
  <th>Valor</th>
  <th>Unidad</th>
  <th>Referencia</th>
</thead>


  <?php foreach($items as $it):?>
    <?php $ie = ResultData::getByIE( $it->id, $exam->id);
//print_r($ie);
    ?>

<tr>
  <td><?php echo $it->name; ?></td>
  <td><?php echo $ie->val; ?></td>
  <td><?php echo $it->unit; ?></td>
  <td><?php echo $it->minimum; ?> - <?php echo $it->maximum; ?></td>
</tr>


<?php endforeach; ?>
</table>

<br>
  <div class="d-grid gap-2">
</div>
</form>

</div>
</div>

</div>
</div>

</div>
</div>
</div>
<?php elseif(isset($_GET["opt"]) && $_GET["opt"]=="open"):

$sell = SellData::getById($_GET['id']);


$contacts = ExamData::getAllBy("sell_id",$_GET['id']);
$payments = PaymentData::getAllBy("sell_id",$_GET['id']);
$total_paid =0;
foreach($payments as $pay){ $total_paid+=$pay->amount;}
  ?>

            <div class="row">
            <div class="col-md-12">
              <div class="card mb-4">
                <div class="card-header">Examenes Realizados de la venta #<?php echo $_GET['id']; ?></div>
                <div class="card-body">


<button type="button" class="btn btn-primary" data-coreui-toggle="modal" data-coreui-target="#exampleModal">
  Agregar Examen a la Venta #<?php echo $sell->id; ?>
</button>
<button type="button" class="btn btn-success" data-coreui-toggle="modal" data-coreui-target="#exampleModalPayment">
  Agregar Pago a la Venta #<?php echo $sell->id; ?>
</button>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Nuevo Examen</h5>
        <button type="button" class="btn-close" data-coreui-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
<form method="post" action="./?action=exams&opt=add2">
  <input type="hidden" name="sell_id" value="<?php echo $_GET['id']?>">
 <input type="hidden" name="person_id" value="<?php echo $sell->person_id; ?>">
  <div class="form-group">
    <label for="exampleInputEmail1">Examen</label>
    <select name="lab_id" required class="form-control">
      <option value="">-- SELECCIONE --</option>
      <?php foreach(LabData::getAll() as $lab):?>
        <option value="<?php echo $lab->id;?>"><?php echo $lab->name;?></option>
      <?php endforeach; ?>
    </select>

  </div>

<br><br>
  <div class="d-grid gap-2">
  <button type="submit" class="btn btn-primary ">Guardar</button>
</div>
</form>

      </div>


    </div>
  </div>
</div>
<!-- Modal -->
<div class="modal fade" id="exampleModalPayment" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Agregar Pago</h5>
        <button type="button" class="btn-close" data-coreui-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
<form method="post" action="./?action=sells&opt=addpayment">
  <input type="hidden" name="sell_id" value="<?php echo $_GET['id']?>">
 <input type="hidden" name="person_id" value="<?php echo $sell->person_id; ?>">
  <div class="form-group">
    <label for="exampleInputEmail1">Pago</label>
    <input type="text" name="amount" required placeholder="Agregar Pago $" class="form-control">

  </div>

<br><br>
  <div class="d-grid gap-2">
  <button type="submit" class="btn btn-primary ">Guardar</button>
</div>
</form>

      </div>


    </div>
  </div>
</div>

                  <!-- /.row--><br><br>
                  <div class="table-responsive">

<?php if(count($contacts)>0):?>
                    <table class="table border mb-0">
                      <thead class="table-light fw-semibold">
                        <tr class="align-middle">

                          <th>#</th>
                          <th class="">Paciente</th>
                          <th class="">Prueba</th>
                          <th class="">Precio</th>
                          <th class="">Status</th>
                          <th class="">Fecha</th>

                          
                          <th></th>
                        </tr>
                      </thead>
                      <tbody>

    <?php 
$total=0;
    foreach($contacts as $con):
      ?>
      <tr>
        <td><a href="javascript:void()" class="btn btn-link btn-sm">#<?php echo $con->id; ?></a></td>
        <td><?php $p = PersonData::getByID($con->person_id); echo $p->name." ".$p->lastname; ?></td>
        <td><?php $l = LabData::getByID($con->lab_id); echo $l->name; ?></td>
        <td>$ <?php echo number_format($l->price,2,".",","); ?></td>
        <td>
        <?php if($con->status==0):?>
          <span class="badge text-bg-warning">Pendiente</span>
          <?php else:?>
            <span class="badge text-bg-success">Finalizado</span>
            <?php endif; ?>  
</td>
        <td><?php echo $con->created_at; ?></td>

        <td>
          <?php if($con->status==0):?>
          <a href="./?action=exams&opt=finalize&id=<?php echo $con->id; ?>" class="btn btn-primary btn-sm"><i class="bi-check"></i> Marcar Finalizado </a>
        <?php endif; ?>

        <a target="_blank" href="./exam.php?id=<?php echo $con->id; ?>" class="btn btn-success btn-sm"><i class="bi-file-text"></i> Ver PDF</a>
          <a href="./?view=exams&opt=viewresults&id=<?php echo $con->id; ?>" class="btn btn-dark btn-sm"><i class="bi-eye"></i> Ver Resultados</a>
          <a href="./?view=exams&opt=capture&id=<?php echo $con->id; ?>" class="btn btn-info btn-sm"><i class="bi-pencil"></i> Captura Resultados</a>
          <a href="./?action=exams&opt=del2&id=<?php echo $con->id; ?>" class="btn btn-danger btn-sm"><i class="bi-trash"></i></a>
        </td>
      </tr>
    <?php 
$total+=$l->price;

  endforeach; ?>
                      </tbody>
                    </table>
                    <br>
<table class="table table-bordered">
  <thead class="table-light fw-semibold">
    <th>Concepto</th>
    <th>$</th>
  </thead>
  <tr>
    <td>Total</td>
    <td>$ <?php echo number_format($total,2,".",","); ?></td>
  </tr>
  <tr>
    <td>Pendiente</td>
    <td>$ <?php $diff = $total-$total_paid ; if($diff>0){ echo number_format($diff,2,".",","); } else { echo 0; } ?></td>
  </tr>
  <tr>
    <td>Pagado</td>
    <td>$ <?php echo number_format($total_paid,2,".",","); ?></td>
  </tr>
</table>


<?php else:?>
  <p class="alert alert-warning">No hay Pruebas de Laboratorio</p>
<?php endif; ?>
                  </div>
                </div>
              </div>
            </div>
            <!-- /.col-->
          </div>


<?php endif; ?>
