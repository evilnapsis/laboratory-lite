<?php 
// si el usuario no esta logeado
if(!isset($_SESSION["user_id"])){ Core::redir("./");}
$user= UserData::getById($_SESSION["user_id"]);
// si el id  del usuario no existe.
if($user==null){ Core::redir("./");}
?>
<?php if(isset($_GET["opt"]) && $_GET['opt']=="all"):
$contacts = ExamData::getAll();
  ?>










            <div class="row">
            <div class="col-md-12">
              <div class="card mb-4">
                <div class="card-header">Examenes Realizados</div>
                <div class="card-body">
<!--<a href="./?view=exams&opt=new" class="btn btn-info">Nuevo Examen</a> -->
                  <!-- /.row-->
                  <div class="table-responsive">

<?php if(count($contacts)>0):?>
                    <table class="table border mb-0">
                      <thead class="table-light fw-semibold">
                        <tr class="align-middle">

                          <th>#</th>
                          <th class="">Paciente</th>
                          <th class="">Prueba</th>
                          <th class=""># Venta</th>
                          <th class="">Precio</th>
                          <th class="">Status</th>
                          <th class="">Fecha</th>

                          
                          <th></th>
                        </tr>
                      </thead>
                      <tbody>

    <?php foreach($contacts as $con):?>
      <tr>
        <td><a href="./?view=exams&opt=open&id=<?php echo $con->id; ?>" class="btn btn-link btn-sm">#<?php echo $con->id; ?></a></td>
        <td><?php $p = PersonData::getByID($con->person_id); echo $p->name." ".$p->lastname; ?></td>
        <td><?php $l = LabData::getByID($con->lab_id); echo $l->name; ?></td>
        <td><a href="./?view=sells&opt=open&id=<?php echo $con->sell_id; ?>" class="btn btn-link btn-sm">#<?php echo $con->sell_id; ?></a></td>
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
          <?php if($con->status==1):?>
        <a target="_blank" href="./exam.php?id=<?php echo $con->id; ?>" class="btn btn-success btn-sm"><i class="bi-file-text"></i> Ver PDF</a>
          <a href="./?view=exams&opt=viewresults&id=<?php echo $con->id; ?>" class="btn btn-dark btn-sm"><i class="bi-eye"></i> Ver Resultados</a>
        <?php endif; ?>
          <a href="./?view=exams&opt=capture&id=<?php echo $con->id; ?>" class="btn btn-info btn-sm"><i class="bi-pencil"></i> Captura Resultados</a>
          <a href="./?view=exams&opt=edit&id=<?php echo $con->id; ?>" class="btn btn-warning btn-sm"><i class="bi-pencil"></i></a>
          <a href="./?action=exams&opt=del&id=<?php echo $con->id; ?>" class="btn btn-danger btn-sm"><i class="bi-trash"></i></a>
        </td>
      </tr>
    <?php endforeach; ?>
                      </tbody>
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













<?php elseif(isset($_GET["opt"]) && $_GET["opt"]=="new"):?>
<div class="">
<div class="row">
<div class="col-md-12">

              <div class="card mb-4">
                <div class="card-header">Examenes </div>
                <div class="card-body">
<h2>Nuevo Examen</h2>

                <div class="row">
                  <div class="col-md-6">
<form method="post" action="./?action=exams&opt=add">
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
        <option value="<?php echo $lab->id;?>"><?php echo $lab->name;?></option>
      <?php endforeach; ?>
    </select>

  </div>
<br>
  <div class="d-grid gap-2">
  <button type="submit" class="btn btn-primary ">Crear</button>
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
<form method="post" action="./?action=exams&opt=update">
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
<form method="post" action="./?action=exams&opt=saveresults">
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
<?php endif; ?>
